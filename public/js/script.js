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

// ///////////////////////////// //
// //// Cart Items Quantity //// //
// ///////////////////////////// //

let navbarCart = document.querySelector('#total-quantity-navbar');

function updateNavQtty() {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status === 200) {
      let response = JSON.parse(this.responseText);
      let totalQtty = response[1];
      if (totalQtty == 0) {
        navbarCart.innerHTML = `<i class="fa-solid fa-cart-shopping fe-lg"></i>`;
      } else if (totalQtty > 99) {
        navbarCart.innerHTML = `<i class="fa-solid fa-cart-shopping fe-lg"></i><span id="total-quantity-navbar" class="cart-item rounded-pill">99+</span>`;
      } else {
        navbarCart.innerHTML = `<i class="fa-solid fa-cart-shopping fe-lg"></i><span id="total-quantity-navbar" class="cart-item rounded-pill">${totalQtty}</span>`;
      }
      // if (totalQtty !== 0) {
      //   navbarCart.innerHTML = `<i class="fa-solid fa-cart-shopping fe-lg"></i><span id="total-quantity-navbar" class="cart-item rounded-pill">${totalQtty}</span>`;
      // } else {
      //   navbarCart.innerHTML = `<i class="fa-solid fa-cart-shopping fe-lg"></i>`;
      // }
    }
  };
  xhttp.open('GET', '/cart/get-total-sum', true);
  xhttp.send();
}

updateNavQtty();

// /////////////////////////// //
// /////// Google Maps /////// //
// /////////////////////////// //

var map;

function initMap() {
  var CodeFactory = {
    lat: 48.19649124145508,
    lng: 16.35948371887207,
  };

  map = new google.maps.Map(document.getElementById('map'), {
    center: CodeFactory,
    zoom: 17,
  });

  var pinpoint = new google.maps.Marker({
    position: CodeFactory,
    map: map,
  });
}
