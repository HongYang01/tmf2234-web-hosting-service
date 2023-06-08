document.addEventListener("DOMContentLoaded", function() {
    const navSwitch = document.querySelector('#navSwitch');
    const navBar2 =document.querySelector('#nav-bar2');
    const navToggle = document.querySelectorAll('.nav-toggle');

    navSwitch.addEventListener("click", () => {
        navBar2.classList.toggle('open');
        navToggle.forEach(icon=>{
            icon.classList.toggle('hidden');
        })
    });
  });

window.addEventListener("resize",()=>{
    const navBar2 =document.querySelector('#nav-bar2');
    const navToggle = document.querySelectorAll('.nav-toggle');
    const menu=document.querySelector('#menu');

    if(document.body.clientWidth > 720){
        navBar2.classList.remove('open');
        navToggle.forEach(icon=>{
            icon.classList.add('hidden')
        });
        menu.classList.remove('hidden');
    }
});