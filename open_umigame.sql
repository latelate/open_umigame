-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 年 6 朁E01 日 14:43
-- サーバのバージョン： 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `open_umigame`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mondai_id` int(11) NOT NULL,
  `kaitou` varchar(255) DEFAULT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `edit` int(11) DEFAULT NULL,
  `editcont` varchar(255) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `i` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `tuuka` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `degreelinks`
--

CREATE TABLE `degreelinks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `addname` varchar(255) NOT NULL DEFAULT '不明',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `degrees`
--

CREATE TABLE `degrees` (
  `id` int(11) NOT NULL,
  `urlid` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `explanation` text,
  `genre` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `closed` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user2_id` int(11) DEFAULT NULL,
  `secretid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `imgs`
--

CREATE TABLE `imgs` (
  `id` int(11) NOT NULL,
  `img_file_name` varchar(255) DEFAULT NULL,
  `mondai_id` int(11) DEFAULT NULL,
  `flg` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `indextags`
--

CREATE TABLE `indextags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `indextemps`
--

CREATE TABLE `indextemps` (
  `id` int(11) NOT NULL,
  `mondai_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `lobbies`
--

CREATE TABLE `lobbies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `nanashiflg` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text,
  `mail` varchar(255) DEFAULT NULL,
  `kind` varchar(255) DEFAULT NULL,
  `flg` int(11) NOT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `minimails`
--

CREATE TABLE `minimails` (
  `id` int(11) NOT NULL,
  `frm` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `content` text,
  `midoku` int(11) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `mondais`
--

CREATE TABLE `mondais` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `kaisetu` mediumtext,
  `comment` varchar(255) DEFAULT NULL,
  `genre` int(11) DEFAULT NULL,
  `stime` varchar(255) DEFAULT NULL,
  `timelog` varchar(255) DEFAULT NULL,
  `scount` int(11) DEFAULT NULL,
  `seikai` int(11) DEFAULT '1',
  `realtime` varchar(255) DEFAULT NULL,
  `summary` text,
  `textflg` int(11) DEFAULT NULL,
  `itijinanashi` int(11) DEFAULT '1',
  `yami` int(11) DEFAULT '1',
  `delete` int(11) DEFAULT '1',
  `twitter` int(11) DEFAULT '0',
  `nanashi` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `endtime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `plantime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `resqs`
--

CREATE TABLE `resqs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mondai_id` int(11) NOT NULL,
  `content` text,
  `answer` varchar(255) DEFAULT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `check` int(11) DEFAULT NULL,
  `radio` varchar(255) DEFAULT NULL,
  `editq` int(11) DEFAULT NULL,
  `edita` int(11) DEFAULT NULL,
  `ediqcont` text,
  `ediacont` varchar(255) DEFAULT NULL,
  `ansflg` int(11) DEFAULT NULL,
  `fa` int(11) DEFAULT NULL,
  `nice` int(11) DEFAULT NULL,
  `textq` int(11) DEFAULT NULL,
  `snipe` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `secretrooms`
--

CREATE TABLE `secretrooms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `secretid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `editflg` int(11) DEFAULT '1',
  `open` int(11) DEFAULT '1',
  `nanashiflg` int(11) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `secrets`
--

CREATE TABLE `secrets` (
  `id` int(11) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text,
  `editcont` text,
  `edit` int(11) DEFAULT NULL,
  `flg` int(11) DEFAULT NULL,
  `hour` int(11) DEFAULT NULL,
  `nanashi` int(11) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `secretuses`
--

CREATE TABLE `secretuses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `nanashi` int(11) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `soudans`
--

CREATE TABLE `soudans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mondai_id` int(11) NOT NULL,
  `edit` int(11) DEFAULT NULL,
  `editcont` text,
  `secret` int(11) DEFAULT NULL,
  `nanashiflg` int(11) DEFAULT NULL,
  `hyouka` int(11) NOT NULL,
  `content` text,
  `created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mondai_id` int(11) DEFAULT NULL,
  `index_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `temples`
--

CREATE TABLE `temples` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mondai_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `add_user_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile` text,
  `degree` varchar(255) DEFAULT NULL,
  `degree_sub` varchar(255) DEFAULT NULL,
  `degreeid` varchar(255) DEFAULT NULL,
  `kisei` int(11) DEFAULT NULL,
  `hyouka` int(11) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `flg` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degreelinks`
--
ALTER TABLE `degreelinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imgs`
--
ALTER TABLE `imgs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indextags`
--
ALTER TABLE `indextags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `indextemps`
--
ALTER TABLE `indextemps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lobbies`
--
ALTER TABLE `lobbies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minimails`
--
ALTER TABLE `minimails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `mondais`
--
ALTER TABLE `mondais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resqs`
--
ALTER TABLE `resqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secretrooms`
--
ALTER TABLE `secretrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secrets`
--
ALTER TABLE `secrets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secretuses`
--
ALTER TABLE `secretuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soudans`
--
ALTER TABLE `soudans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temples`
--
ALTER TABLE `temples`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `degreelinks`
--
ALTER TABLE `degreelinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imgs`
--
ALTER TABLE `imgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indextags`
--
ALTER TABLE `indextags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `indextemps`
--
ALTER TABLE `indextemps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lobbies`
--
ALTER TABLE `lobbies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `minimails`
--
ALTER TABLE `minimails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mondais`
--
ALTER TABLE `mondais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resqs`
--
ALTER TABLE `resqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secretrooms`
--
ALTER TABLE `secretrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secrets`
--
ALTER TABLE `secrets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `secretuses`
--
ALTER TABLE `secretuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soudans`
--
ALTER TABLE `soudans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temples`
--
ALTER TABLE `temples`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
