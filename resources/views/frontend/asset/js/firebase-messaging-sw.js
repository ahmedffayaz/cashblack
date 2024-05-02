self.addEventListener('push', function(event) {
    const payload = event.data.json();
    const { title, body, icon } = payload.notification;
  
    event.waitUntil(
      self.registration.showNotification(title, {
        body: body,
        icon: icon
      })
    );
});
