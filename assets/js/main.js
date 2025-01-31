document.getElementById('toggleBg').addEventListener('change', function() {
    if (this.checked) {
        console.log('test');
        document.body.classList.remove('body_effects');
    } else {
        document.body.classList.add('body_effects');
    }
});