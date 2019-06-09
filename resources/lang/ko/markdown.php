<?php

return [
    'header' => '마크다운 문법',
    'headings' => [
        'title' => '제목들',
        'description' => '제목을 만들려면 제목 텍스트 앞에 1개에서 6개의 # 기호를 추가합니다. 사용하는 `#`의 수에 따라 머리글의 크기가 결정됩니다.',
        'example' => "# 가장 큰 제목 8-)\n## 두번째로 큰 제목\n###### 가장 작은 제목",
    ],
    'horizontal_rules' => [
        'title' => '수평 자',
        'description' => '',
        'example' => "___\n---\n***",
    ],
    'typographic_replacements' => [
        'title' => '대체 텍스트',
        'description' => '',
        'example' => "(c) (C) (r) (R) (tm) (TM) (p) (P) +-\n\ntest.. test... test..... test?..... test!....\n\n!!!!!! ???? ,,  -- ---\n\n\"Smartypants, double quotes\" and 'single quotes'",
    ],
    'styling_text' => [
        'title' => '스타일링 텍스트',
        'description' => '강조 표시는 굵게, 기울임꼴 또는 삭제선 텍스트로 지정할 수 있습니다.',
        'example' => "스타일 | 문법 | 예시 | 출력\n----- | --------|----------|--------\n굵게 | `** **` 또는 `__ __` | `**굵은 텍스트**` | **굵은 텍스트**\n기울임 | `* *` 또는 `_ _` | `*기울인 텍스트*` | *기울인 텍스트*\n삭제선 | `~~ ~~` | `~~삭제선 텍스트~~` | ~~삭제선 텍스트~~\n굵고 기울게 | `** **` 그리고 `_ _` | `**이 텍스트는 _극도로_ 중요하다**` | **이 텍스트는 _극도로_ 중요하다**",
    ],
    'quoting_text' => [
        'title' => '텍스트 인용',
        'description' => '<code>></code>로 텍스트를 인용할 수 있습니다.',
        'example' => "> Blockquotes can also be nested...\n>> ...by using additional greater-than signs right next to each other...\n> > > ...or with spaces between arrows.",
    ],
    'quoting_code' => [
        'title' => '코드 인용',
        'description1' => '단일 억음부호(`)로 문장 내에서 코드 또는 명령을 호출할 수 있습니다. 억음부호(`) 내의 텍스트는 포맷되지 않습니다.',
        'example1' => '아직 커밋되지 않은 모든 새 파일 또는 수정된 파일을 나열하려면 `git status`를 사용합니다.',
        'description2' => '코드 또는 텍스트를 고유한 블록으로 포맷하려면 세개의 억음부호(`)를 사용합니다.',
        'example2' => "몇 가지 기본 git 명령:\n```\ngit status\ngit add\ngit commit\n```",
    ],
    'links' => [
        'title' => '링크',
        'description' => '링크 텍스트를 괄호 <code>[]</code>로 포장한 다음 URL을 괄호 <code>()</code>로 포장하여 인라인 링크를 만들 수 있습니다.',
        'example' => '이 사이트는 [라라벨 5.8](https://laravel.com/docs/5.8)을 사용하여 구축되었습니다.',
    ],
    'lists' => [
        'title' => '목록',
        'description1' => '무질서한',
        'example1' => "+ `+`, `-` 또는 `*` 행을 시작하여 목록을 작성합니다.\n+ 하위 목록은 2개의 공백을 삽입하여 만듭니다:\n  - 마커 문자 변경으로 인해 새 목록이 시작됩니다:\n    * Ac tristique libero volutpat at\n    + Facilisis in pretium nisl aliquet\n    - Nulla volutpat aliquam velit\n+ 매우 쉽습니다!",
        'description2' => '정돈된',
        'example2' => "1. Lorem ipsum dolor sit amet\n2. Consectetur adipiscing elit\n3. Integer molestie lorem at massa\n1. 순차 숫자를 사용할 수 있습니다...\n1. ...아니면 모든 숫자를 <code>1</code>로 유지하세요.",
        'description3' => '오프셋을 사용하여 번호 매기기 시작:',
        'example3' => "57. foo\n1. bar",
    ],
    'code' => [
        'title' => '코드',
        'example1' => '인라인 `코드`',
        'description2' => '인덴트 코드',
        'example2' => "    // Some comments\n    line 1 of code\n    line 2 of code\n    line 3 of code",
        'description3' => '코드 모음',
        'example3' => "```\n샘플 문자를 여기에...\n```",
        'description4' => '구문 강조 표시',
        'example4' => "```javascript\nlet foo = bar => bar++;\n\nconsole.log(foo(5));\n```",
    ],
];
