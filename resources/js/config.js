var api_url = '';
var app_url = ''
var amap_js_api_key = '	8269d8a1c887cbcbb5b59ec9295a7e89';

switch( process.env.NODE_ENV ){
    case 'development':
        api_url = 'http://www.blog.com/api/v1';
        app_url = 'http://www.blog.com';
        break;
    case 'production':
        api_url = 'http://blog.blackpeal.com/api/v1';
        app_url = 'http://blog.blackpeal.com'
        break;
}

export const ROAST_CONFIG = {
    API_URL: api_url,
    App_URL: app_url,
    AMAP_JS_API_KEY: amap_js_api_key
}