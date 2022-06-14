const myAxios = axios.create({
    baseURL: '/api/',
    timeout: 1000,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});