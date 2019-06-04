class Error {
    /**
     * 새로운 Error 인스턴스를 생성합니다.
     */
    constructor() {
        this.errors = {};
    }

    /**
     * 주어진 필드에 에러 내용을 반환합니다.
     *
     * @param   {string} field
     * @returns {string|void}
     */
    get(field) {
        if (this.has(field)) {
            return this.errors[field][0];
        }
    }

    /**
     * 주어진 필드에 대한 에러가 있는지 확인합니다.
     *
     * @param   {string} field
     * @returns {boolean}
     */
    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    /**
     * 한개 혹은 모든 에러 필드를 청소합니다.
     *
     * @param   {string|null} field
     * @returns {boolean}
     */
    clear(field = null) {
        if (field) {
            return delete this.errors[field];
        }

        this.errors = {};
    }

    /**
     * 새로운 에러를 저장합니다.
     *
     * @param {object} errors
     */
    record(errors) {
        this.errors = errors;
    }
}

export default Error;
