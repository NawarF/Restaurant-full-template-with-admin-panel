let mineu= document.querySelector('.mineu');
let bar =document.querySelector("#bar-btn");


bar.onclick = ()=>{
    bar.classList.toggle("fa-times");
    mineu.classList.toggle("active");
   
}

let cancelbtn =document.querySelector("#cancel-btn");

cancelbtn.onclick = ()=>{
document.querySelector("#edit-form-section").style.display ='none';
window.location.href ="admin.php";

}



