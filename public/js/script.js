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
// plus.forEach((btn, i) => {
//   btn.addEventListener('click', () => {
//     plusQtty(i);
//   });
// });

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

// /////////////////////////// //
// /////// Google Maps /////// //
// /////////////////////////// //

// var map;

// function initMap() {
//   map = new google.maps.Map(document.getElementById('map'), {
//     center: { lat: 48.20849, lng: 16.37208 },
//     zoom: 8,
//   });
// }

// var map;

function initMap() {
  var CodeFactory = {
    lat: 48.19649124145508,
    lng: 16.35948371887207,
  };

  map = new google.maps.Map(document.getElementById('map'), {
    center: CodeFactory,
    zoom: 17,
  });

  console.log(map);

  var pinpoint = new google.maps.Marker({
    position: CodeFactory,
    map: map,
  });
}

function loadDoc(e, id) {
  let xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (this.status == 200) {
      // document.getElementById('content').innerHTML = this.responseText;
      console.log(this.responseText);
      console.log(e.nextElementSibling);
      e.nextElementSibling.value = this.responseText;
    }
  };
  xhttp.open('GET', '/cart/plus/' + id, true);
  xhttp.send();
}
