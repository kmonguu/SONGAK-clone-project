<?
// 최고관리자
if ($member[mb_id] == 'admin') $is_admin = 'super';
if ($member[mb_id] == 'aaaa') $is_admin = 'super';
if ($member[mb_id] == 'itmaster') $is_admin = 'super';


// 그룹관리자
if ($gr_id == '그룹아이디')
{
    if ($member[mb_id] == 'itmaster') $is_admin = 'group';
   // if ($member[mb_id] == '회원아이디2') $is_admin = 'group';
   // if ($member[mb_id] == '회원아이디3') $is_admin = 'group';
}

// 게시판관리자
if ($bo_table == '게시판아이디')
{
    if ($member[mb_id] == 'itmaster') $is_admin = 'board';
  //  if ($member[mb_id] == '회원아이디2') $is_admin = 'board';
  //  if ($member[mb_id] == '회원아이디3') $is_admin = 'board';

    if ($is_admin == 'board') $board[bo_admin] = $member[mb_id];
}

?>