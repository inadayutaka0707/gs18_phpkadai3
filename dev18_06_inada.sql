-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_kadai`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_bm_table`
--

CREATE TABLE `gs_bm_table` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `sex` text NOT NULL,
  `age` text NOT NULL,
  `time` datetime NOT NULL,
  `password` text NOT NULL,
  `image` varchar(128) NOT NULL,
  `loginflag` tinyint(1) NOT NULL,
  `checkflag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `gs_bm_table`
--

INSERT INTO `gs_bm_table` (`id`, `name`, `email`, `sex`, `age`, `time`, `password`, `image`, `loginflag`, `checkflag`) VALUES
(4, 'test', 'test@test.com', '男性', '26', '2021-01-11 08:29:49', '$2y$10$eEk/C8jBT/HMQGIIBbM3QeopKUO0TkFcMClzDBMRgoxl7qqX3WwZi', './img/php.jpg', 0, 0),
(5, 'test1', 'test1@test.com', '男性', '10', '2021-01-11 08:30:08', '$2y$10$mQezBfWtr9iZsQxlwZUuXuT4G6xZlXcGTm5s5fvinyJuyjrJz9vTy', './img/php.jpg', 0, 0),
(6, 'test2', 'test2@test.com', '男性', '10', '2021-01-11 08:30:23', '$2y$10$fuO5piApGJ08zeS5cuOtzu9JdKPAH/oSTL4.g4vhdBSt4ysWpOXuK', './img/6印鑑.jpg', 1, 0),
(7, 'いなだ', 'test3@test.com', '男性', '10', '2021-01-12 21:33:12', '$2y$10$tU1knDma3ZhCKPWEsP4loO2u1lHe9DOqgqNOk1Eb9I3DjzCuEO7nq', './img/php.jpg', 0, 0),
(8, 'yuyu', 'yuyu@yuyu', '男性', '10', '2021-01-15 23:31:58', '$2y$10$W16xAnDN9nCAUSkmKS9xk.UZPGGKc6U57JU7Yw8RjPtfa4Ici2Vzq', './img/php.jpg', 0, 0),
(9, 'ゆたか', 'yuyuyu@yuyyu', '男性', '10', '2021-01-15 23:49:31', '$2y$10$zY30jsUNLWAT6ZWlXYwLT.KURdUQXLpegNYKHSJ4DTQYV9owJzAUm', './img/php.jpg', 0, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_follow_table`
--

CREATE TABLE `gs_follow_table` (
  `id` int(12) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `followid` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `gs_follow_table`
--

INSERT INTO `gs_follow_table` (`id`, `userid`, `followid`) VALUES
(42, '4', '5'),
(44, '5', '4'),
(45, '5', '6'),
(48, '6', '5'),
(50, '7', '5'),
(52, '7', '6'),
(54, '6', '7'),
(65, '9', '8'),
(67, '8', '9'),
(68, '6', '4'),
(70, '6', '9');

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_tweet_table`
--

CREATE TABLE `gs_tweet_table` (
  `id` int(12) NOT NULL,
  `userid` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `tweet` varchar(256) NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `gs_tweet_table`
--

INSERT INTO `gs_tweet_table` (`id`, `userid`, `name`, `email`, `tweet`, `date`, `image`) VALUES
(10, 4, 'test', 'test@test.com', 'test', '2021-01-11 08:30:40', './img/php.jpg'),
(11, 5, 'test1', 'test1@test.com', 'test1', '2021-01-11 08:30:54', './img/php.jpg'),
(25, 6, 'test2', 'test2@test.com', 'test2', '2021-01-11 15:33:29', './img/6印鑑.jpg'),
(26, 5, 'test1', 'test1@test.com', 'daf', '2021-01-11 16:34:28', './img/php.jpg'),
(27, 7, 'いなだ', 'test3@test.com', 'test\r\n', '2021-01-12 21:33:29', './img/php.jpg'),
(28, 7, 'いなだ', 'test3@test.com', 'teste', '2021-01-12 21:33:33', './img/php.jpg'),
(29, 4, 'test', 'test@test.com', 'フォーマットを編超す', '2021-01-15 22:51:45', './img/php.jpg'),
(30, 4, 'test', 'test@test.com', 'スタイルマジムズイ', '2021-01-15 23:17:54', './img/php.jpg'),
(31, 8, 'yuyu', 'yuyu@yuyu', 'functionにまとめます\r\nふぁｄｓ', '2021-01-15 23:32:45', './img/php.jpg'),
(33, 9, 'ゆたか', 'yuyuyu@yuyyu', 'fdafasdf\r\nfdafasdfa', '2021-01-16 00:00:05', './img/php.jpg');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `name` (`name`);

--
-- テーブルのインデックス `gs_follow_table`
--
ALTER TABLE `gs_follow_table`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `gs_tweet_table`
--
ALTER TABLE `gs_tweet_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルのAUTO_INCREMENT `gs_follow_table`
--
ALTER TABLE `gs_follow_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- テーブルのAUTO_INCREMENT `gs_tweet_table`
--
ALTER TABLE `gs_tweet_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
