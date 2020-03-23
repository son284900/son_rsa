/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/03
 */
class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        // data.api_key = process.env.MIX_API_KEY;
        this.originalData = data;
        for (const field in data) {
            this[field] = data[field];
        }

    }

    /**
     * Fetch all relevant data for the form.
     */
    jsonData() {
        const data = {};

        for (const property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }

    /**
     * Fetch all relevant data for the GET Parameter.
     */
    requestParam() {
        let data = '';

        for (const property in this.originalData) {

            if (data) {
                data = data+'&'+property+'='+this[property];

            } else {
                data = property+'='+this[property];

            }

        }

        return data;
    }

    /**
     * Return true if the form is incompleted.
     */
    incompleted() {
        return !this.completed();
    }

    /**
     * Return true if the form is completed.
     */
    completed() {
        for (const field in this.originalData) {
            if (this[field] === '' || this[field] === null) {
                return false;
            }
        }

        return true;
    }

    /**
     * Reset the form fields and errors.
     */
    reset() {
        this.resetFields();
    }

    /**
     * Reset the form fields and errors.
     */
    resetFields() {
        for (const field in this.originalData) {
            this[field] = '';
        }
    }
}

export default Form;
