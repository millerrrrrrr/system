<?php
include_once 'connectdb.php';
session_start();

if ($_SESSION['username'] == "") {
    header('location:../index.php');
}

include_once "header.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">QR Scanner</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
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
                            <!-- Scanner view area -->
                            <video id="qr-video" style="width: 100%; height: 400px;"></video>

                            <div id="user-info" style="margin-top: 20px; padding: 10px; background-color: #f4f4f4; border-radius: 5px; display: none;">
                                <h6><strong>User Information:</strong></h6>
                                <p><strong>Name:</strong> <span id="user-name"></span></p>
                                <p><strong>LRN:</strong> <span id="user-lrn"></span></p>
                                <p><strong>Grade:</strong> <span id="user-grade"></span></p>
                                <p><strong>Section:</strong> <span id="user-section"></span></p>
                                <p><strong>Guardian's Name:</strong> <span id="user-gname"></span></p>
                                <p><strong>Guardian's Contact:</strong> <span id="user-gcontact"></span></p>
                                <p><strong>Address:</strong> <span id="user-address"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once "footer.php";
?>

<!-- Include jsQR Library -->
<script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>

<script>
    const videoElement = document.getElementById('qr-video');
    const userInfoDiv = document.getElementById('user-info');
    const userNameSpan = document.getElementById('user-name');
    const userLrnSpan = document.getElementById('user-lrn');
    const userGradeSpan = document.getElementById('user-grade');
    const userSectionSpan = document.getElementById('user-section');
    const userGNameSpan = document.getElementById('user-gname');
    const userGContactSpan = document.getElementById('user-gcontact');
    const userAddressSpan = document.getElementById('user-address');

    // Initialize webcam
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        .then(function (stream) {
            videoElement.srcObject = stream;
            videoElement.setAttribute("playsinline", true); // required to play video on iPhone
            videoElement.play();
            scanQRCode(); // Start scanning QR codes continuously
        })
        .catch(function (err) {
            console.error('Error accessing the camera: ', err);
        });

    // Function to scan QR code
    function scanQRCode() {
        const canvasElement = document.createElement('canvas');
        const canvas = canvasElement.getContext('2d');
        
        // This function runs every 100ms to scan the video for QR codes
        setInterval(function () {
            if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
                canvasElement.height = videoElement.videoHeight;
                canvasElement.width = videoElement.videoWidth;
                canvas.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);
                const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                const code = jsQR(imageData.data, canvasElement.width, canvasElement.height, {
                    inversionAttempts: 'dontInvert',
                });
                
                if (code) {
                    // QR code is detected
                    handleQRCodeData(code.data);
                }
            }
        }, 100); // Continuously scan for QR codes every 100ms
    }

    // Handle the QR code data
    function handleQRCodeData(data) {
        // Send the QR data to the backend for validation
        fetch('validate_qr.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ qrData: data })
        })
        .then(response => response.json())
        .then(responseData => {
            if (responseData.success) {
                // Display user information from the response
                userInfoDiv.style.display = 'block';
                userNameSpan.textContent = responseData.name;
                userLrnSpan.textContent = responseData.lrn;
                userGradeSpan.textContent = responseData.grade;
                userSectionSpan.textContent = responseData.section;
                userGNameSpan.textContent = responseData.gname;
                userGContactSpan.textContent = responseData.gcontact;
                userAddressSpan.textContent = responseData.address;
            } else {
                // Handle the case where no student is found
                alert(responseData.message);
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            alert('There was an error processing the QR code.');
        });

        // DO NOT stop the video stream here, camera will remain open
        // Removed the code that stops the video:
        // const stream = videoElement.srcObject;
        // const tracks = stream.getTracks();
        // tracks.forEach(track => track.stop());
    }
</script>
