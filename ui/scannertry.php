<?php
include_once 'connectdb.php';
session_start();

if ($_SESSION['username'] == "") {
    header('location:../index.php');
}

include_once "header.php";
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QR Scanner</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- QR Scanner Column -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Scan Your QR Code</h5>
                        </div>
                        <div class="card-body">
                            <video id="qr-video" style="width: 100%; height: 400px; transform: scaleX(-1);"></video>
                        </div>
                    </div>
                </div>

                <!-- User Info Column -->
                <div class="col-lg-6">
                    <div class="card" id="user-info" style="display: none;">
                        <div class="card-header">
                            <h5 class="m-0">Student Information</h5>
                        </div>
                        <div class="card-body">
                            <!-- Student Details -->
                            <p><strong>Name:</strong> <span id="user-name"></span></p>
                            <p><strong>LRN:</strong> <span id="user-lrn"></span></p>
                            <p><strong>Grade:</strong> <span id="user-grade"></span></p>
                            <p><strong>Section:</strong> <span id="user-section"></span></p>
                            <p><strong>Guardian's Name:</strong> <span id="user-gname"></span></p>
                            <p><strong>Guardian's Contact:</strong> <span id="user-gcontact"></span></p>
                            <p><strong>Address:</strong> <span id="user-address"></span></p>

                            <!-- Attendance Details -->
                            <hr>
                            <h5>Today's Attendance</h5>
                            <p><strong>Date:</strong> <span id="attendance-date"></span></p>
                            <p><strong>Morning In:</strong> <span id="morning-in"></span></p>
                            <p><strong>Morning Out:</strong> <span id="morning-out"></span></p>
                            <p><strong>Afternoon In:</strong> <span id="afternoon-in"></span></p>
                            <p><strong>Afternoon Out:</strong> <span id="afternoon-out"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>

<!-- Include jsQR Library -->
<script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>

<script>
    const videoElement = document.getElementById('qr-video');
    const userInfoDiv = document.getElementById('user-info');

    // Student Info Elements
    const userNameSpan = document.getElementById('user-name');
    const userLrnSpan = document.getElementById('user-lrn');
    const userGradeSpan = document.getElementById('user-grade');
    const userSectionSpan = document.getElementById('user-section');
    const userGNameSpan = document.getElementById('user-gname');
    const userGContactSpan = document.getElementById('user-gcontact');
    const userAddressSpan = document.getElementById('user-address');

    // Attendance Info Elements
    const attendanceDateSpan = document.getElementById('attendance-date');
    const morningInSpan = document.getElementById('morning-in');
    const morningOutSpan = document.getElementById('morning-out');
    const afternoonInSpan = document.getElementById('afternoon-in');
    const afternoonOutSpan = document.getElementById('afternoon-out');

    // Start camera and QR scanning
    navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'environment'
            }
        })
        .then(function(stream) {
            videoElement.srcObject = stream;
            videoElement.setAttribute("playsinline", true);
            videoElement.play();
            scanQRCode();
        })
        .catch(function(err) {
            console.error('Camera error: ', err);
        });

    function scanQRCode() {
        const canvasElement = document.createElement('canvas');
        const canvas = canvasElement.getContext('2d');

        setInterval(function() {
            if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
                canvasElement.height = videoElement.videoHeight;
                canvasElement.width = videoElement.videoWidth;
                canvas.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                const code = jsQR(imageData.data, canvasElement.width, canvasElement.height);

                if (code) {
                    handleQRCodeData(code.data);
                }
            }
        }, 100);
    }

    function handleQRCodeData(data) {
        try {
            const parsedData = JSON.parse(data);
            const lrn = parsedData.lrn;

            if (lrn) {
                fetch('validate_qr.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            lrn: lrn
                        })
                    })
                    .then(response => response.json())
                    .then(responseData => {
                        if (responseData.success) {
                            userInfoDiv.style.display = 'block';

                            // Student info
                            userNameSpan.textContent = responseData.name;
                            userLrnSpan.textContent = responseData.lrn;
                            userGradeSpan.textContent = responseData.grade;
                            userSectionSpan.textContent = responseData.section;
                            userGNameSpan.textContent = responseData.gname;
                            userGContactSpan.textContent = responseData.gcontact;
                            userAddressSpan.textContent = responseData.address;

                            // Attendance info
                            // Set today's date when QR code is scanned
                            const dateToday = new Date();
                            const options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            };
                            attendanceDateSpan.textContent = dateToday.toLocaleDateString(undefined, options);

                            morningInSpan.textContent = responseData.morningIn || 'N/A';
                            morningOutSpan.textContent = responseData.morningOut || 'N/A';
                            afternoonInSpan.textContent = responseData.afternoonIn || 'N/A';
                            afternoonOutSpan.textContent = responseData.afternoonOut || 'N/A';
                        } else {
                            alert(responseData.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Error processing QR code.');
                    });
            } else {
                alert("Invalid QR data.");
            }
        } catch (e) {
            console.error("QR parse error:", e);
            alert("Invalid QR data.");
        }
    }
</script>