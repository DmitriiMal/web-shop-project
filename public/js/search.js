function search(){
   let element = document.querySelector("#searchTxt");
   let txt = element.value;
   let xhr = new XMLHttpRequest();
   xhr.onload = function(){
      if(this.status == 200){

         // console.log(this.responseText);
      }
   };
   xhr.open('GET', '/search/' + txt, true);
   xhr.send();
}