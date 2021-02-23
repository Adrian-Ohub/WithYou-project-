Echo.private(`App.User.${laravel.user}`)
  .notification((notification) => {
  console.log(notification);
    swal.fire({
      title: `${notification.user[0].nombre}`,
      text: 'ha hecho match WITH YOU!',
      imageUrl: src="src/logo30.png",
      imageWidth: 75,
      imageHeight: 75,
      imageAlt: 'logo30.png',
      confirmButtonText: 'Ok'
    }).then(function(){
      location.reload();
    });  
});