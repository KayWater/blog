import { CONFIG } from '../config.js';

class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload
        this.loader = loader;
    }
    // Starts the upload process
    upload() {
        return this.loader.file.then( file => new Promise( (resolve, reject ) => {
            this._initRequest();
            this._initListeners( resolve, reject, file);
            this._sendRequest( file );
        } )  );
    }
    
    // Aborts the upload process
    abort() {
        if( this.xhr ) {
            this.xhr.abort();
        }
    }
    // Initializes the XMLHttpRequest Object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();
        
        xhr.open('POST', CONFIG.API_URL + '/editor/upload', true);
        xhr.responseType = 'json';
    }
    // Initializes the XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = "couldn't upload file: "+file.name;
        
        xhr.addEventListener('error', () => reject(genericErrorText));
        xhr.addEventListener('abort', () => reject());
        xhr.addEventListener('load', () => {
            const response = xhr.response;
            
            //Handle upload errors
            if( ! response || response.error ) {
                return reject(response && response.error ? response.error.message : genericErrorText );
            }
            
            // If the upload is successful, resolve the upload promise with an obejct
            // containing at least the 'default' URL, pointing to the image on the server.
            // This URL will be used to display the image in the content
            resolve({
                default: response.url
            });
        });
        
        // Upload progress when it is support. The file loader has the #uploadTotal and
        // #uploaded properties which are used e.g. to display the upload progress bar 
        // in the editor user interface.
        if( xhr.upload ) {
            xhr.addEventListener('progress', evt => {
                if( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            })
        }
    }
    // Prepares the data adn sends the request.
    _sendRequest( file ) {
        const data = new FormData();
        // CSRF protection.
        data.append("_token", document.querySelector("meta[name='csrf-token']").getAttribute('content'));
        data.append('upload', file);
        
        this.xhr.send(data);
    }
}


export function customUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}