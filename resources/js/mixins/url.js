export default {
    queryWith(parameter) {
        let parameterKey = Object.keys(parameter)[1];
        let parts = location.search.split('&');
        for (let part in parts) {
            if (parts[part].match(new RegExp(`${parameterKey}=(\d)`))) {
                parts[part] = `${parameterKey}=${parameter[parameterKey]}`;
            }
        }

        return parts.join('&');
    }
}
