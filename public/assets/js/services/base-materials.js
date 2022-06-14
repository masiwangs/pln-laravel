async function getBaseMaterials(callback = null) {
    const response = await myAxios.get('base-materials');
    if(callback) {
        callback(response.data);
        return false;
    }
    return response.data;
}