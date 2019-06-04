class Translator {
    /**
     * 새로운 Translator 인스턴스를 생성합니다.
     *
     * @param {Object} lines
     */
    constructor(lines = {}) {
        this.lines = lines;
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
     * @return {string}
     */
    trans(key) {
        return this.get(key);
    }

    /**
     * 주어진 키에 해당하는 번역을 반환합니다.
     *
     * @param  {string} key
     * @param  {array}  attributes
     * @return {string}
     */
    get(key, attributes = []) {
        let line = _.get(this.lines, key, key);

        attributes.forEach((replacement, attribute) => line = _.replace(line, `:${attribute}`, replacement));

        return line;
    }
}

export default Translator;
