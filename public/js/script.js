const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click',()=>{
	container.classList.add('active');
})

loginBtn.addEventListener('click',()=>{
	container.classList.remove('active');
})

document.querySelectorAll('.coming-soon').forEach(el => {
    el.addEventListener('click', function(e) {
        e.preventDefault();
        alert('Fitur belum tersedia');
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href'))
            .scrollIntoView({ behavior: 'smooth' });
    });
});