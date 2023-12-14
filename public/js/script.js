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

const swiper = new Swiper('.swiper', {
  // Optional parameters
  direction: 'horizontal',
  loop: true,

  // If we need pagination
  // pagination: {
  //   el: '.swiper-pagination',
  // },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  // scrollbar: {
  //   el: '.swiper-scrollbar',
  // },
});
