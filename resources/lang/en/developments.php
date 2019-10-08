<?php

return [
    'title' => 'Developments',
    'list' => 'List',
    'empty' => 'There is no article registered.<br><a href="' . route('developments.create') . '" class="btn btn-outline-primary mt-2">Writing</a>',
    'create' => 'Writing a new article',
    'body_placeholder' => "Please fill out the text.\nThe document supports markdown grammar.",
    'submit' => 'Submit',
    'store' => 'Saved.',
    'copy_url' => 'Copy URL',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'cancel' => 'Cancel',
    'confirm_cancel' => "Are you sure you want to cancel?\nThe modifications will not be saved.",
    'confirm_destroy' => "Are you sure you want to delete it?\nDeleted content cannot be recovered.",
    'copied' => 'Copied.',
    'updated' => 'Updated.',
    'deleted' => 'Deleted.',
    'trending' => 'Trendings',
    'search' => 'Search',
    'search_placeholder' => 'Search for the title and content.',
    'searching' => 'Searching...',
    'autocomplete_placeholder' => 'Press <b>enter</b> to select, <b>↑↓</b> to navigate, <b>esc</b> to dismiss',
    'tags_placeholder' => ' Select #Tag',
    'filter_by_tag' => 'Filter by Tag',
    'empty_tags' => 'No tags used.',
    'show_more' => 'Show more',
    'show_less' => 'Show less',
    'multi_select' => [
        'select_label' => 'Press enter to select',
        'group_label' => 'Press enter to select group',
        'selected_label' => 'Selected',
        'deselect_label' => 'Enter 키를 눌러 제거',
        'deselect_group_label' => 'Press enter to remove',
        'max_elements' => 'Maximum of :max options selected. First remove a selected option to select another.',
        'no_result' => 'No elements found. Consider changing the search query.',
        'no_options' => 'List is empty.',
    ],
    'uploaded_images' => 'Uploaded Images',
    'uploaded_image' => 'The image has been saved. Please check the route.',
    'temporary' => [
        'store' => 'Temporary development saved',
        'updated' => 'Temporary development updated',
    ],
];
