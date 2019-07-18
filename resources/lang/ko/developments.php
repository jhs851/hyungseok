<?php

return [
    'title' => '기술 개발',
    'list' => '모든 글',
    'empty' => '등록된 글이 없습니다.<br><a href="' . route('developments.create') . '" class="btn btn-outline-primary mt-2">글쓰기</a>',
    'create' => '새글 쓰기',
    'body_placeholder' => "본문을 작성해주세요.\n해당 문서는 마크다운 문법을 지원합니다.",
    'submit' => '발행',
    'store' => '저장되었습니다.',
    'copy_url' => 'URL 복사',
    'edit' => '수정하기',
    'delete' => '삭제하기',
    'cancel' => '취소',
    'confirm_cancel' => "정말 취소하시겠습니까?\n수정한 내용이 저장되지 않습니다.",
    'confirm_destroy' => "정말 삭제하시겠습니까?\n삭제된 내용은 복구할 수 없습니다.",
    'copied' => '복사되었습니다.',
    'updated' => '수정되었습니다.',
    'deleted' => '삭제되었습니다.',
    'my_developments' => '나의 글',
    'popularity' => '인기있는 글',
    'trending' => '유행하고 있는 글',
    'search' => '검색',
    'search_placeholder' => '제목 및 내용을 검색하세요.',
    'searching' => '검색중...',
    'autocomplete_placeholder' => '선택하려면 <b>enter</b> 키를 누르고, 탐색하려면 <b>↑↓</b>, 취소하려면 <b>esc</b>를 누르세요',
    'tags_placeholder' => ' #태그를 선택해주세요.',
    'filter_by_tag' => '태그에 의해 필터',
    'empty_tags' => '사용된 태그가 없습니다.',
    'show_more' => '더보기',
    'show_less' => '덜보기',
    'multi_select' => [
        'select_label' => 'Enter 키를 눌러 선택',
        'group_label' => 'Enter 키를 눌러 그룹을 선택',
        'selected_label' => '선택된',
        'deselect_label' => 'Enter 키를 눌러 제거',
        'deselect_group_label' => 'Enter 키를 눌러 그룹을 제거',
        'max_elements' => '최대 :max 옵션이 선택되었습니다. 먼저 선택한 옵션을 제거하여 다른 옵션을 선택하세요.',
        'no_result' => '결과를 찾을 수 없습니다. 검색 쿼리를 변경하는 것을 고려하세요.',
        'no_options' => '목록이 비어 있습니다.',
    ],
    'uploaded_images' => '업로드된 이미지들',
    'uploaded_image' => '이미지가 저장 됐습니다. 경로를 확인해주세요.',
];
