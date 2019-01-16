$(document).ready(function(){
	ClassicEditor
    .create( document.querySelector( '#editor' ), {
		image: {
			toolbar: [],
		},
    }).then( newEditor => {
        editor = newEditor; 
        editor.isReadOnly = true;
//        $(editor.ui.view.editable.element).css("border", 0);
//        $(editor.ui.view.toolbar.element).hide();
    }).catch( error => {
        console.log( error );
    } );
});
