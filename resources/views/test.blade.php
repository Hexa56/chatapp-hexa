<!doctype html>
<html>

<head lang="en">
    
<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
</head>

<body>
   
<script>
  const beamsClient = new PusherPushNotifications.Client({
    instanceId: 'b570c72f-f28f-4dd6-873a-7d044c1deb54',
  });

  beamsClient.start()
    .then(() => beamsClient.addDeviceInterest('hello'))
    .then(() => console.log('Successfully registered and subscribed!'))
    .catch(console.error);
</script>
</body>

</html>