// ///////////////////////// //
// ////// Sweet Alert ////// //
// ///////////////////////// //

let okAlert = () => {
  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Your work has been saved',
    showConfirmButton: false,
    timer: 1500,
  });
};

let button = document.getElementById('button');
button.addEventListener('click', okAlert);

// ///////////////////////// //
// ///////// Swiper //////// //
// ///////////////////////// //
