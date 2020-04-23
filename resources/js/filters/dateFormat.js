import Vue from 'vue';
import moment from 'moment';
moment.locale('zh-cn');

Vue.filter('momentFromNow', function(date) {
    return moment(date).fromNow();
});

Vue.filter('momentFormat', function(date, string) {
    return moment(date).format(string);
});