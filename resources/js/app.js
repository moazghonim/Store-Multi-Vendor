import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


var channel = Echo.private(`App.models.user.${$user_id}`);
channel.notification(function (data) {
    console.log(data);
    alert(data.body);
});
