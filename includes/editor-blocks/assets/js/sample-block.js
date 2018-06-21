/**
 * Very simple sample block.
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 * 
 * This may be removed as an editable sample block evolves.
 * 
 * @since 1.0.0
 */

( function() {
	// The __() for internationalization.
	var __ = wp.i18n.__;

	// The wp.element.createElement() function to create elements.
	var el = wp.element.createElement;

	// The registerBlockType() to register blocks.
	var registerBlockType = wp.blocks.registerBlockType;

	/**
	* Register Basic Block.
	*
	* Registers a new block provided a unique name and an object defining its
	* behavior. Once registered, the block is made available as an option to any
	* editor interface where blocks are implemented.
	*
	* @param  {string}   name     Block name.
	* @param  {Object}   settings Block settings.
	* @return {?WPBlock}          The block, if it has been successfully
	*                             registered; otherwise `undefined`.
	*/

	/**
	* Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	* Block icon from Dashicons.
	* Block category common, formatting, layout, widgets, embed.
	*/
	registerBlockType( 'ccp/sample-block', {
		title    : __( 'Sample Block', 'controlled-chaos-plugin' ),
		icon     : 'lightbulb',
		category : 'common',

		// The "edit" property must be a valid function.
		edit: function(props) {
			// Creates a <p class='wp-block-ccp-sample-block"'></p>.
			return el(
				'p', // Tag type.
				{ className: props.className }, // The class="wp-block-ccp-sample-block" : The class name is generated using the block's name prefixed with wp-block-, replacing the / namespace separator with a single -.
				'Sample Block' // Content inside the tag.
			);
		},

		// The "save" property must be specified and must be a valid function.
		save: function(props) {
			return el(
				'p', // Tag type.
				{ className: props.className }, // The class="wp-block-ccp-sample-block" : The class name is generated using the block's name prefixed with wp-block-, replacing the / namespace separator with a single -.
				'Sample Block' // Content inside the tag.
			);
		}
	});
})
();