const formulario = document.querySelector('.formulario'),
      inputs = document.querySelectorAll('.formulario input'),
      sign_in_container = document.querySelector('.sign-in-container'),
      sign_up_container = document.querySelector('.sign-up-container');

console.log(inputs)      

document.addEventListener('click', e => {
    if (e.target.matches('.ok-account')) {
        sign_in_container.style.display='block';
        sign_up_container.style.display="none";  
    } else if (e.target.matches('.n o-account')) {
        sign_up_container.style.display="block";
        sign_in_container.style.display="none";
    }

})

const expresiones_regulares = {
    Nombre: /^[a-zA-Z]{1,40}$/,
    Telefono: /^[0-9]$/,
    id: /^[0-9]$/,
    Cargo: /^[a-zA-z]{1,40}$/,
    Email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
    Contraseña: /^.{4,12}$/
}