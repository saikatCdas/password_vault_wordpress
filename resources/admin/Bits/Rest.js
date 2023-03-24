const request = function (method, route, data = {}) {
    const url = `${window.fluentFrameworkAdmin.rest.url}/${route}`;

    const headers = {'X-WP-Nonce': window.fluentFrameworkAdmin.rest.nonce};

    if (['PUT', 'PATCH', 'DELETE'].indexOf(method.toUpperCase()) !== -1) {
        headers['X-HTTP-Method-Override'] = method;
        method = 'POST';
    }

    if (method !== 'GET' && method !== 'UPLOAD') {
        data = JSON.stringify(data);
    }

    if (method === 'UPLOAD') {
        return window.jQuery.ajax({
            url: url,
            type: "POST",
            data: data,
            contentType: false,
            cache: false,
            processData: false
        });
    }

    return window.jQuery.ajax({
        url: url,
        type: method,
        data: data,
        headers: headers,
        contentType: 'application/json'
    });
}

export default {
    get(route, data = {}) {
        return request('GET', route, data);
    },
    post(route, data = {}) {
        return request('POST', route, data);
    },
    delete(route, data = {}) {
        return request('DELETE', route, data);
    },
    put(route, data = {}) {
        return request('PUT', route, data);
    },
    patch(route, data = {}) {
        return request('PATCH', route, data);
    },
    upload(route, data = {}) {
        return request('UPLOAD', route, data);
    }
};

jQuery(document).ajaxSuccess((event, xhr, settings) => {
    const nonce = xhr.getResponseHeader('X-WP-Nonce');
    if (nonce) {
        window.fluentFrameworkAdmin.rest_nonce = nonce;
    }
});
