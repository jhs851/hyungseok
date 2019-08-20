<?php

return [
    'failed' => '입력하신 로그인 정보가 올바르지 않습니다.',
    'throttle' => '로그인 시도가 너무 많습니다. 몇 초 후에 다시 시도하세요.',
    'login' => '로그인',
    'register' => '회원가입',
    'remember' => '로그인 기억하기',
    'forgot_password' => '비밀번호를 잊으셨나요?',
    'welcome' => ':name님 환영합니다!',
    'logout' => '로그아웃',
    'logged_out' => '또 방문해주세요 :)',
    'already_logined' => '이미 로그인 하셨습니다.',
    'unauthenticated' => '로그인 후에 이용 가능합니다.',
    'sending' => '이메일 전송중...',
    'passwords' => [
        'reset' => '비밀번호 초기화',
        'send' => '비밀번호 초기화 링크 보내기',
    ],
    'verify' => [
        'title' => '이메일 주소 확인',
        'description' => '이메일을 인증하시려면 아래 버튼으로 이메일 인증 메일을 전송하세요!',
        'send' => '이메일 인증 메일 보내기',
        'sent' => '이메일 인증 링크가 귀하의 메일 주소로 전송되었습니다.',
        'verified' => '이메일이 인증 되었습니다.',
        'ensure' => '귀하의 이메일 주소는 인증이 필요합니다.',
        'already' => '귀하의 이메일은 인증되어 있습니다.',
    ],
    'social' => [
        'not_supported' => '[:provider] 은(는) 지원하지 않는 소셜 로그인 입니다.',
        'with_naver' => '네이버로 로그인',
        'with_kakao' => '카카오로 로그인',
        'with_github' => '깃헙으로 로그인',
        'with_google' => '구글로 로그인',
        'with_facebook' => '페이스북으로 로그인',
        'invalid' => '유효하지 않습니다',
        'reasons_of_invalid' => '다음 유효성 검사를 통과하지 못해 소셜 로그인에 실패했습니다.',
        'retry' => '다시 시도',
    ],
    'activities' => '활동내역',
    'created_development' => '작성한 개발 포스트들',
    'created_comment' => '작성한 댓글들',
    'created_favorite' => '좋아한 글들',
    'empty_activities' => '활동 내역이 없습니다.<br><a href="' . route('developments.create') . '" class="btn btn-outline-primary mt-2">글쓰기</a>',
    'avatars' => [
        'title' => '드래그해서 사용할 영역을 선택해주세요!',
        'store' => '저장되었습니다.',
        'submit' => '저장하기',
        'fail_to_create_image' => '이미지 생성에 실패했습니다.',
        'removed' => '삭제되었습니다.',
        'edit' => '아바타 변경하기',
        'destroy' => '아바타 삭제하기',
    ],
];
