<?php

return [
    'unauthorize' => '권한이 없습니다.',
    'letter_to_me' => '서두르지 말고 천천히 하나씩. 테스트에 힘을 더 쏟아야 할만큼 테스트 정성스럽게. 리팩토링에 시간 많이 들어가도 계속 하다보면 줄어들테니 넘기지말고. 귀찮아 하지말고 해야된다고 생각되는건 반드시 하길',
    'dashboard' => [
        'title' => '대시보드',
        'traffic_this_month' => '이번달 트래픽',
        'unit' => '단위(:unit)',
        'last_1_hour_cpu_usage' => '최근 1시간 CPU 사용량',
        'aws_s3_usage' => 'AWS S3 사용량',
        'database_useage' => '데이터베이스 사용량',
    ],
    'developments' => [
        'total' => '모든 개발 포스트들',
        'increase' => '이번 달에 :percentage% 상승',
        'month_of_new' => '한 달간 새로운 글',
        'most_visited' => '방문이 가장 많은 글',
        'writer' => '작성자',
        'comments_count' => '댓글 수',
        'visits_count' => '방문 수',
        'created_at' => '작성일',
    ],
    'comments' => [
        'title' => '댓글',
        'total' => '총 댓글 수',
        'most_commentable' => '가장 많은 댓글이 달린 글',
        'empty' => '등록된 댓글이 없습니다.',
    ],
    'tags' => [
        'total' => '총 태그 수',
        'most_mentioned' => '가장 많이 언급된 태그',
        'unmentioned_tags' => '언급되지 않은 태그들',
        'create' => '태그 생성',
        'mentions_count' => '언급 된 수',
        'empty' => '등록된 태그가 없습니다.<br><a href="' . route('admin.tags.create') . '" class="btn btn-outline-primary mt-2">태그 생성</a>',
    ],
    'favorites' => [
        'title' => '좋아요',
        'total' => '모든 좋아요 수',
        'most_favorited' => '가장 많은 좋아요를 받은 글',
        'writer' => '좋아한 사람',
        'type' => '타입',
        'favorited_post' => '좋아한 글',
        'created_at' => '좋아한 날',
        'empty' => '좋아한 기록이 없습니다 :(',
    ],
    'notifications' => [
        'title' => '알림',
        'read_notifications' => '읽은 알림들',
        'unread_notifications' => '읽지 않은 알림들',
        'read_empty' => '읽은 알림이 없습니다.',
        'unread_empty' => '읽지 않은 알림이 없습니다.',
        'marked' => '읽음 상태로 표시했습니다.',
    ],
    'users' => [
        'title' => '사용자',
        'total' => '총 사용자 수',
        'month_of_new' => '한 달간 새로운 사용자',
        'active_users' => '활성화 된 사용자',
        'unactive_users' => '비활성화 된 사용자',
        'search_placeholder' => '이름 및 이메일을 검색하세요.',
        'create' => '사용자 생성',
        'avatar' => '아바타',
        'active_status' => '활성 상태',
        'created_at' => '가입일',
        'edit' => '사용자 변경',
        'active' => '활성화',
        'unactive' => '비활성화',
        'is_admin' => '관리자 유무',
        'admin' => '관리자',
        'general' => '일반 회원',
        'destroy' => '사용자 삭제',
        'store' => '사용자를 생성 했습니다.',
    ],
];
