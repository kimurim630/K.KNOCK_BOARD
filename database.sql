CREATE DATABASE IF NOT EXISTS  board_db;

USE board_db; -- board라는 데이터 베이스를 만들고 사용

-- 사용자 테이블: 아이디(중복 불가), 비밀번호 해시, 가입 시각
CREATE TABLE IF NOT EXISTS users (
  id         INT PRIMARY KEY AUTO_INCREMENT, -- AUTO_INCREMENT -> 1씩 증가
  username   VARCHAR(50)  NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 게시글 테이블: 제목, 본문, 작성자(users 참조), 작성·수정 시각
CREATE TABLE IF NOT EXISTS posts (
  id         INT PRIMARY KEY AUTO_INCREMENT,
  title      VARCHAR(200) NOT NULL,
  content    TEXT,
  author_id  INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                      ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES users(id) -- FOREIGN KEY로 자식테이블 열 이름 REFERENCES로 부모 테이블 이름
);
-- 댓글 레이블: 어느 글(post_id)에, 누가(author_id), 무슨 내용을 남겼는지
CREATE TABLE IF NOT EXISTS comments (
  id         INT PRIMARY KEY AUTO_INCREMENT,
  post_id    INT NOT NULL,
  author_id  INT NOT NULL,
  content    TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (post_id)   REFERENCES posts(id),
  FOREIGN KEY (author_id) REFERENCES users(id)
);
