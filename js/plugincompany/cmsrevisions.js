/**
 *
 * Created by:  Milan Simek
 * Company:     Plugin Company
 *
 * LICENSE: http://plugin.company/docs/magento-extensions/magento-extension-license-agreement
 *
 * YOU WILL ALSO FIND A PDF COPY OF THE LICENSE IN THE DOWNLOADED ZIP FILE
 *
 * FOR QUESTIONS AND SUPPORT
 * PLEASE DON'T HESITATE TO CONTACT US AT:
 *
 * SUPPORT@PLUGIN.COMPANY
 *
 */

/*
* Opens new window with chosen CMS Page revision
*
* */
function previewcms(button) {
    var buttonSiblings = button.siblings();
    var dropdown = buttonSiblings[0];
    window.open(dropdown.getValue());
}

/*
* Loads block data from chosen revision into editor
*
* */
function loadRevisionBlockData(blockDataURL) {
    new Ajax.Request(blockDataURL, {
        onSuccess: function(response) {
            var blockData = response.responseJSON;
            $('block_title').setValue(blockData.title);
            $('block_content').value = blockData.content;
            $('block_identifier').setValue(blockData.identifier);
            tinyMCE.activeEditor.setContent(blockData.content);
        },
        onFailure: function(){
            alert('failed to load block data')
        }
    });

}

function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete this revision?")) {
   document.location = delUrl;
  }
}