<!DOCTYPE html>
<html>
<head>
  <title>Popup Notification</title>
  <style>
    #popup-notification {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.3);
      width: 80%;
      max-width: 400px;
      background-color: #f8d7da;
      padding: 10px;
      display: none;
    }
    #show-popup-button {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <button id="show-popup-button" onclick="showPopup()">Show Notification</button>
  <div id="popup-notification">
    <p>alert!</p>
    <button id="close-button" onclick="hidePopup()">Close</button>
  </div>
  <script>
    var popup = document.getElementById("popup-notification");
    
    function showPopup() {
      popup.style.display = "block";
    }
    
    function hidePopup() {
      popup.style.display = "none";
    }
  </script>
</body>
</html>
