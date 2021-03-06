import Error from './Error';

class Form {
    /**
     * 새로운 Form 인스턴스를 생성합니다.
     *
     * @param {object} data
     */
    constructor(data = {}) {
        this.original = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Error;
    }

    /**
     * 폼에 대한 모든 관련 데이터를 가져옵니다.
     *
     * @return {object}
     */
    data() {
        let data = {};

        for (let property in this.original) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * 폼 필드를 초기화합니다.
     */
    reset() {
        for (let field in this.original) {
            this[field] = '';
        }

        this.errors.clear();
    }

    /**
     * 폼 필드를 되돌립니다.
     */
    revert() {
        for (let field in this.original) {
            this[field] = this.original[field];
        }
    }

    /**
     * 주어진 URL에 GET 요청을 보냅니다.
     *
     * @param   {string} url
     * @returns {Promise<any>}
     */
    get(url) {
        return this.submit('get', url);
    }

    /**
     * 주어진 URL에 POST 요청을 보냅니다.
     *
     * @param   {string} url
     * @returns {Promise<any>}
     */
    post(url) {
        return this.submit('post', url);
    }

    /**
     * 주어진 URL에 PUT 요청을 보냅니다.
     *
     * @param   {string} url
     * @returns {Promise<any>}
     */
    put(url) {
        return this.submit('put', url);
    }

    /**
     * 주어진 URL에 delete 요청을 보냅니다.
     *
     * @param   {string} url
     * @returns {Promise<any>}
     */
    delete(url) {
        return this.submit('delete', url);
    }

    /**
     * 주어진 URL에 주어진 request type 요청을 보냅니다.
     *
     * @param  {string} requestType
     * @param  {string} url
     * @return {Promise<any>}
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(({data}) => {
                    this.success(data);

                    resolve(data);
                })
                .catch(error => {
                    this.fail(error.response.data);

                    reject(error.response.data);
                });
        });
    }

    /**
     * 성공한 형태를 핸들링합니다.
     *
     * @param {object} data
     */
    success(data) {
        if (data.hasOwnProperty('message')) {
            toastr.success(data.message);
        }

        this.original = this.data();
        this.errors.clear();
    }

    /**
     * 실패한 형태를 핸들링합니다.
     *
     * @param {object} data
     */
    fail(data) {
        if (data.hasOwnProperty('errors')) {
            return this.errors.record(data.errors);
        }

        toastr.error(data.message);
    }
}

export default Form;
