class Translator {
    /**
     * 새로운 Translator 인스턴스를 생성합니다.
     */
    constructor() {
        if (! window.hasOwnProperty('i18n')) {
            throw 'Failed to retrieve translation file.';
        }
    }

    /**
     * 주어진 키의 번역이 있는지 확인합니다.
     *
     * @param  {string} key
     * @return {boolean}
     */
    has(key) {
        return this.get(key) !== key;
    }

    /**
     * 주어진 키에 해당하는 번역을 반환합니다.
     *
     * @param  {string} key
     * @param  {object} attributes
     * @return {string}
     */
    trans(key, attributes = {}) {
        return this.get(key, attributes);
    }

    /**
     * 주어진 키에 해당하는 번역을 반환합니다.
     *
     * @param  {string} key
     * @param  {object} attributes
     * @return {string}
     */
    get(key, attributes = {}) {
        let line = _.get(window.i18n, key, key);

        _.eachRight(attributes, (paramValue, paramKey) => line = _.replace(line, `:${paramKey}`, paramValue));

        return line;
    }
}

export default Translator;
