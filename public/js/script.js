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

let plus = document.querySelectorAll('.plus');
let minus = document.querySelectorAll('.minus');
let quantity = document.getElementsByClassName('quantity');

//increases item quantity
plus.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    plusQtty(i);
  });
});

const plusQtty = (index) => {
  quantity[index].value++;
};

//decreases item quantity
minus.forEach((btn, i) => {
  btn.addEventListener('click', () => {
    minusQtty(i);
  });
});

const minusQtty = (index) => {
  quantity[index].value--;
  if (quantity[index].value < 0) {
    quantity[index].value = 0;
  }
};

// console.log(quantity[0].value);
