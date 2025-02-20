@extends('master')

@include('navbar')

@section('content')
<div class="container">
    <h2 class="text-centre">Enter your URL here</h2>
    <form id="urlForm">
        @csrf
        <div class="form-group">
            <input type="text" name="url" id="urlInput" class="form-control" placeholder="Enter your URL here" required>
        </div>
        <button type="submit" class="btn btn-primary">Shorten</button>
        <br>
        <h3>Your shortened URL:</h3>
        <div class="url" id="shortenedUrl"></div>
        <hr>
    </form>
</div>

<div class="container">
    <h2 class="text-centre">Enter shortened URL here</h2>
    <form id="originalUrlForm">
        @csrf
        <div class="form-group">
            <input type="text" name="url" id="originalUrlInput" class="form-control" placeholder="Enter your URL here" required>
        </div>
        <button type="submit" class="btn btn-primary">Retrieve</button>
        <br>
        <h3>Original URL:</h3>
        <div class="url" id="originalUrl"></div>
        <hr>
    </form>
</div>

<script>
document.getElementById('urlForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const url = document.getElementById('urlInput').value;
    const token = document.querySelector('input[name="_token"]').value;

    axios.post('/api/encode', { url: url }, {
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => {
        if (response.data.short_url) {
            document.getElementById('shortenedUrl').innerHTML = `<a href="${response.data.short_url}" target="_blank">${response.data.short_url}</a>`;
        } else {
            document.getElementById('shortenedUrl').innerHTML = 'Error shortening URL';
        }
    })
    .catch(error => {
        document.getElementById('shortenedUrl').innerHTML = 'Error shortening URL';
    });
});

document.getElementById('originalUrlForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const url = document.getElementById('originalUrlInput').value;
    const token = document.querySelector('input[name="_token"]').value;

    axios.post('api/decode', { url: url }, {
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => {
        if (response.data.original_url) {
            document.getElementById('originalUrl').innerHTML = `<a href="${response.data.original_url}" target="_blank">${response.data.original_url}</a>`;
        } else {
            document.getElementById('originalUrl').innerHTML = 'Error retrieving URL';
        }
    })
    .catch(error => {
        document.getElementById('originalUrl').innerHTML = 'Error retrieving URL';
    });
});
</script>
@endsection