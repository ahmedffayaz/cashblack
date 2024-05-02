function getImageUrl(url) {
    if (url === '' || url == null || (typeof url == 'undefined' && url.image === '')) {
        return null;
    }

    if (typeof url !== 'undefined' && url.image != '') {
        var baseDir = url.is_fake == 1 ? 'frontend/images/logos/' : '';

        return url.image.indexOf('http') !== -1
            ? (!url.image ? window.location.origin + 'storage/__asset/img/no-logo.png' : url.image)
            : window.location.origin + '/' + baseDir + url.image;
    }

    return url.indexOf('http') !== -1 ? url : window.location.origin + url;
}
