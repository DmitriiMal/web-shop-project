// ///////////////////////// //
// ////// Sweet Alert ////// //
// ///////////////////////// //

let okAlert = () => {
  Swal.fire({
    position: 'top-end',
    icon: 'success',
    title: 'Product added to cart',
    showConfirmButton: false,
    timer: 1500,
  });
};

// Forgotten password?
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map((popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl));

// ////////////////////////// //
// ////// Cart buttons ////// //
// ////////////////////////// //

let plus = document.getElementsByClassName('plus');
let minus = document.getElementsByClassName('minus');
let quantity = document.getElementsByClassName('quantity').value;
let order = document.getElementsByClassName('order');

// for (let i = 0; i < plus.length; i++) {
//   const element = plus[i].addEventListener('click', increase);
// }

// let increase = () => {};
// console.log(typeof quantity);
