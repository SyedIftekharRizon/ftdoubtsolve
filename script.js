document.getElementById('myForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(document.getElementById('myForm'));

    fetch('upload.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text()).then(data => {
        alert(data);
    }).catch(error => {
        console.error('Error:', error);
    });
});
