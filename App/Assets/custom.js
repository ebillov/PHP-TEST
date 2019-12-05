/**
 * Define global Ajax for API Controller usage
 */
window.apiAjax = class apiAjax {

    /**
     * Here we define our constructor
     * @param {string} url The request url
     * @param {function} callback The callback function for the request
     * @param {string} api_token The unique api_token key per user
     * @param {array} serialized_data The serialized array data from the form
     * @param {string} method The method used for the request
     * @param {string} csrf_token The X-CSRF-TOKEN protection
     */
    constructor(url, callback, serialized_data = null, method = 'get'){
        this.url = url;
        this.serialized_data = serialized_data;
        this.method = method;
        this.query(callback);
    }

    /**
    * The main ajax request method
    * @param {function} callback The the method name and type of request
    */
   query(callback){

        jQuery.ajax({
            url: this.url,
            data: this.serialized_data,
            method: this.method,
            success: function(data){
                if(typeof callback === 'function'){
                    callback(data);
                }
            },
            error: function(errors){
                if(typeof callback === 'function'){
                    callback(errors);
                }
            }
        });

    }

};