-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024 年 06 月 03 日 17:53
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `group_29`
--
CREATE DATABASE IF NOT EXISTS `group_29` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `group_29`;

-- --------------------------------------------------------

--
-- 資料表結構 `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bio` text DEFAULT '暫無簡介',
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `penName` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `author`
--

INSERT INTO `author` (`id`, `username`, `bio`, `password`, `phone`, `email`, `penName`, `is_admin`) VALUES
(1, 'aaa', '本名羅傳樵，一九八二年生，畢業於東吳大學中文系、臺灣大學哲學所東方組碩士班，專長是儒學。性善論者。對人類學、民俗學、城市發展、腦科學等等有興趣。曾於臺大原住民族研究中心工作，現為臺北地方異聞工作室（網站、FB專頁）共同創辦人。現已出版《臺北城裡妖魔跋扈》、《帝國大學赤雨騷亂》、《金魅殺人魔術》、《都市傳說冒險團：謎樣的作家》、《殖民地之旅》、《魔神仔：被牽走的巨人》，曾參與《華麗島軼聞：鍵》、《筷：怪談競演奇物語》、《歡迎光臨錫爾帕夏車站》等聯合創作計畫。實境遊戲設計師，曾策劃〈金魅殺人魔術〉、〈西門町的四月笨蛋〉、〈城市邊陲的遁逃者〉等實境遊戲，並參與「說妖」的桌遊設計。', '$2y$10$HsCMWggQwqTj.ebApZ8VquKs69VtoHHHlfASnRyI9rgrE5qCLSuha', '09123456789', 'something@gmail.com', '瀟湘神', 0),
(2, 'jjjghu', '就讀資訊工程學系的大二學生，\r\n目前正為了自己的未來發愁，就像隨處可見的大二學生一樣', '$2y$10$DtGLkN9sBqpHXLV23g6IXu2QRuASKXF9DlP8OamW4y/FXNHK585Ge', '0933884740', 'chiuliyou@gmail.com', 'jjjghu', 1),
(5, 'cuesta3085', '暫無資料', '$2y$10$4l1WAV0HvfX6dvgC5ULcNOWs/eIpoBYQPKWzyUAY8KEufhSuWxRNm', '0900780455', 'itanki3085@gmail.com', '在地裡的人', 0),
(22, 'insaneboy58669', '暫無資料', '', '5555666688', 'Wooo@gmail.com', '臉接大招', 0),
(34, 'SunSet', '暫無資料', '', '1234554321', 'SunSet@gmail.com', '夕陽掛', 0),
(48, 'elderDirt', '對歷史充滿熱情，熱愛探索古董背後的故事。相信每一件古董都是時光的見證者，記錄著過去的風華。', '$2y$10$aXXXV2LhiahQrnR/skhOd.Q3QvcWPg5Bol0TMo78hV3bFD4sIdRB.', '5544778899', 'elderDirt@elderDirt', '月底吃土', 0),
(49, 'LearningMaster', '學得快，省的時間就多，省的時間越多，就能夠玩更多遊戲，所以學得快 = 玩得多。', '$2y$10$wMYngx69M4ujEO4ezQUj7ONFMr8.XgclstEwmU0CkBxILooiJM6Yq', '0956324502', 'LearningFast@gmail.com', '超學習大師', 0),
(50, 'IceAndFire', '自我簡介不重要', '$2y$10$xm2VRi42.AyQPFlV6eLJt.6lvTZXt63WACbRV1SgkRYfwrwCCYJji', '1534867890', 'Ice@fire', '冰與火之哥', 0),
(51, 'PlasticBottle', '願我如星君如月，夜夜流光相皎潔!', '$2y$10$eTLfSid1K1sWCDRb02iVpe2Qs.xYp1Rihr3MZ4./cKjMy4102V1kW', '4589122682', 'Plastic@bottle', '張拓', 0),
(52, 'Neko', '專職鏟屎官，業餘貓咪攝影師。每天和貓主子鬥智鬥勇，記錄下那些萌翻天的小瞬間。', '$2y$10$WFZ6vjPGR37w6aiezf1ImuCOFTbLnvts.y1oR06TYkjvDwHeD01tu', '4568885550', 'ne@ko', '喵醬油', 0),
(53, 'FireKeeper', '深夜圖書館的常客，無書不歡。喜歡在安靜的角落裡品味文字的美好，認為每一本書都是一段心靈的旅程。', '$2y$10$dCK8JAMI6OOVehYOJB/4yu8c7HiMhwb2sD8bng8IYiXgmkfQQf0M.', '1231231230', 'FIre@keeper', '書蟲君', 0),
(54, 'LaughOutLoud', '人生來就是要笑，哈哈哈哈哈哈!', '$2y$10$lMdcUTWEOJiXJbWt/TjLBeo96clsIchQ38BfIfqi7bjx9qRSsjd3K', '5558884440', 'Laugh@out', '把我的快樂留給自己', 0),
(55, 'shadowassassin', '暫無資料', '$2y$10$b3Ca7NTQWMhm/UE7cGGPuOjAXCQAsmQ/kSPjRpbd4A9qB95c9FzPq', '1234564560', 'shadow@assassin', '暗影獵手', 0),
(56, 'spectator', '社會觀察家，熱衷於記錄和分析現實生活中的矛盾與衝突。以冷靜的筆觸揭示人性的複雜。', '$2y$10$GPU7gH4qxhgLDeiOJGSrzOi6Aaw.rd.SMvudlxfPL0y8YQNPmrMXi', '5467897890', 'spec@spec', '冷眼旁觀', 0),
(57, 'Lies', '熱愛歷史與虛構結合，專注於創作虛構的歷史事件和人物。相信虛構歷史中也能找到現實的真理。', '$2y$10$CTWrC.V8RNluI1nCumML0eZpaucW8EIrNlo4TRvoYEMZtP9VJhBqS', '1324564560', 'Lies@True', '虛構史學家', 0),
(58, 'Dieway', '暫無資料', '$2y$10$IY9o.Hx.viseugT3LKaIx.tNpVT5GwJ6OnoMsc5fzYfh0d74s4LjS', '4555666889', 'Die@way', '呆惟', 0),
(59, 'Dancer', '舞!舞!!舞!!! 接著奏樂接著舞!', '$2y$10$h1GbNkDb6JLaqjug9npp1eYkj7sjTK7ltbgwwn43ri8Gs9crbAPA2', '4445577788', 'dan@cer', '幻', 0),
(60, 'solo', '長劍在我手，天下任我遊!', '$2y$10$z4xtIyHQ6c027Iw4l6Yndu29AhaGsjZQ6qL/gh7tYCTmIzlbyoOre', '1111111111', 'solo@solo', '我要打十個', 0),
(61, 'Block', '打怪、建築、冒險，這就是我的人生！Minecraft就是我的戰場，我要成為那個站在方塊世界頂端的王者！任何挑戰都無法阻擋我的腳步，讓我們在方塊世界中一起燃燒吧！', '$2y$10$ZJxi0FDkMTagZTth9nN04.R1sIknbEUbJiUBiwGvhx4jsH8IFzcUm', '7139713971', 'Block@Block', '無限指令方塊', 0),
(62, 'HotBoy', '在這個冷酷的世界，唯有熱血與夢想能夠點燃生命的火焰！我是那個要在逆境中生長的種子，縱然風雨再大，也無法撲滅我心中的烈火！', '$2y$10$xJPj7ItdZl8bt1ZBfOj7WOAUI9erWtoZEUt9dTquIwprs8QrqN5pu', '9999999999', 'hot@boy', '橘黃色山脈', 0),
(63, 'Poem', '一劍一詩行走江湖，心中藏著千古柔情。身為詩情劍客，既能舞劍斬敵，也能筆下生花，寫盡世間相思之苦。', '$2y$10$CjZxTq9xa58jVZZ7A73IHeK5Ax69wCaTcnytBW7FjMqSSU187QLc2', '5584840055', 'Poem@Poem', '詩情劍客', 0),
(64, 'DestroyerOfWorld', '(自我簡介由於不可抗力因素，變成了一串亂碼)\r\n███████████████\r\n█████為了█████在月食██████\r\n██我不想██████\r\n', '$2y$10$Dx.emKR9FjhbCLIBved1TeLQ8KyQz9fN2m/CJyT/WIn5iDsW0HVLm', '5555544444', 'Destroy@World', '滅世', 0),
(65, 'admin', '暫無資料', '$2y$10$.fHDlDBWvW/VGBeWG1eQPOHBVYuh9RZE.F0vyf1j/hME1T0QPJiR6', '5555588888', 'admin@admin', 'admin', 1),
(97, 'root', '暫無簡介', '$2y$10$VQJaEZUGxx23CU55UgqJie/gFPXGhSLXi1bhq.F/F9f3Ikoh5eRza', '1234568794', 'Deleter@Deleter', NULL, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(0, '全部'),
(2, '回憶集錦'),
(3, '智識留心'),
(4, '詭譎暗影'),
(5, '虛構敘事'),
(6, '懸疑推理'),
(7, '現實寫實'),
(8, '科幻幻想'),
(9, '靈異神怪'),
(10, '愛情故事'),
(11, '歷史紀實'),
(12, '冒險奇遇'),
(13, '幽默搞笑'),
(14, '自傳回憶'),
(15, '社會觀察'),
(16, '哲理思考'),
(17, '散文隨筆'),
(18, '詩詞歌賦'),
(19, '武俠小說');

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `write_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `author_id`, `write_date`) VALUES
(2, '思明的日記', 0.00, 2, '2024-05-19'),
(3, 'AI產業的今日與未來 (上)', 300.00, 2, '2024-05-20'),
(4, '地理小知識 ─ 闢謠重現期', 50.00, 5, '2024-05-22'),
(7, '大海盡頭的落日', 15.99, 22, '2024-05-20'),
(8, '記憶中的未來', 14.99, 22, '2024-06-10'),
(9, '百歲人生: 長壽時代的生活和工作', 18.89, 48, '2024-07-15'),
(10, '為甚麼你總是學得慢?', 260.00, 49, '2024-08-05'),
(11, '水火交融的末日', 600.00, 50, '2024-09-25'),
(12, '懸日', 280.00, 51, '2024-08-14'),
(13, '晚雲收', 230.00, 51, '2024-11-01'),
(14, '祂和祂的對話', 450.00, 51, '2025-01-16'),
(15, '家裡有隻貓', 360.00, 52, '2023-11-28'),
(16, '病案本', 480.00, 54, '2021-01-07'),
(17, '弒罪人', 450.00, 55, '2026-07-20'),
(18, '社會觀察', 400.00, 56, '2027-01-15'),
(19, '古董的故事', 380.00, 48, '2027-03-10'),
(20, '虛構的帝國', 420.00, 57, '2027-05-05'),
(21, '羌笛與強敵', 460.00, 56, '2028-03-20'),
(22, '古墓驚魂', 420.00, 51, '2028-05-10'),
(23, '歷史的回聲', 450.00, 48, '2023-10-19'),
(24, '火樹銀花', 400.00, 56, '2013-05-08'),
(25, '淒艷的波光', 450.00, 59, '2026-06-15'),
(26, '臨光', 550.00, 60, '2027-08-15'),
(27, '凋零風暴', 480.00, 61, '2027-11-05'),
(28, '燃燒的種子', 500.00, 62, '2027-10-20'),
(29, '相思', 450.00, 63, '2028-02-14'),
(30, '關於知識蒸餾(K.D.)的小心得', 1299.00, 5, '2024-05-31');

-- --------------------------------------------------------

--
-- 資料表結構 `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(2, 5),
(3, 3),
(4, 3),
(7, 2),
(8, 2),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 5),
(14, 6),
(15, 2),
(16, 16),
(17, 6),
(18, 15),
(19, 11),
(20, 5),
(21, 11),
(22, 12),
(23, 11),
(24, 11),
(25, 5),
(26, 19),
(27, 12),
(28, 19),
(29, 19);

-- --------------------------------------------------------

--
-- 資料表結構 `product_comment`
--

CREATE TABLE `product_comment` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product_comment`
--

INSERT INTO `product_comment` (`id`, `product_id`, `content`, `author_name`, `author_id`, `comment_date`) VALUES
(49, 2, '更改留言', 'jjjghu', 0, '2024-06-03 15:34:36'),
(51, 3, '新的留言!', 'jjjghu', 0, '2024-06-03 17:09:19'),
(53, 2, '新的留言加入了!', 'HotBoy', 62, '2024-06-03 17:24:25'),
(54, 2, 'NewComment', 'HotBoy', 62, '2024-06-03 17:24:27'),
(55, 2, '新留言', 'HotBoy', 62, '2024-06-03 17:24:33'),
(56, 2, '新留言', 'HotBoy', 62, '2024-06-03 17:26:13');

-- --------------------------------------------------------

--
-- 資料表結構 `product_contents`
--

CREATE TABLE `product_contents` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `intro` text NOT NULL,
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product_contents`
--

INSERT INTO `product_contents` (`id`, `product_id`, `intro`, `detail`) VALUES
(2, 2, '思名的日記，當中記錄了一種名叫「失情」的病緩慢發作的過程', '「失情」是一種病症，病如其名，會讓人漸漸失去感受情感的能力。\r\n\r\n我一直都不是一個樂觀開朗的人，但我一直很想成為那樣的人。\r\n\r\n童年時，家中時常出遊，山川、老街、夜市、廟宇。童年的記憶看似單薄，可一旦深挖，便會發現一處處湧泉。\r\n\r\n不知從何開始，出遊的次數銳減，\r\n學黌佔據我大多數的時間，我的作息開始不規律，考試只會讓我如釋重負，或是得到糟糕的心情。\r\n\r\n我發現自己對閱讀有興趣，讀的不是散文、詩歌，而是網路小說，再到後來，我發現自己搞錯了，我喜歡的是故事本身，跟表現形式無關。\r\n我開始記錄自己的生活，想把那些珍貴的回憶寫下來，我將它們一個個封存，以便我隨時翻看，讓這個世界的顏色，不要流逝的那麼快。\r\n...\r\n...\r\n日子大多像平靜的湖面，就這樣蹉跎光陰，日復一日。\r\n草木榮枯，四季輪轉，隨著年紀增長，時間移動的速度越來越快了，我開始時常會想，人死後會到哪裡去？\r\n\r\n死亡會從何時，用什麼樣的方式降臨？每思及此，心底便有股濃郁漆黑的恐懼蔓延，震顫著大腦。\r\n真好，至少我還感受的到恐懼。\r\n...\r\n...\r\n為了治好自己的病症，恢復從前鮮活的情感，\r\n我閱讀了大量典籍，順手醫治了很多人，不知不覺，我成了丹頂司最好的丹士。\r\n\r\n我試過很多方法，但無一例外都失敗了，有幾次還險些身死。\r\n\r\n我的情緒變動的越來越緩慢，像是要變成一攤死水，可心裡沒有一絲一毫的焦慮或是不安，興許是因為焦慮慣了，不安久了，自然也就無感了。\r\n\r\n有時我會想，既然生來注定，又為甚麼要去反抗呢? \r\n不是我的終究不會是我的，縱使掙扎的再劇烈，也只會落得相同的下場，外加變得更深的勒痕，長生種百年的壽命，此時卻顯得那樣的可怖，沒有了情緒，我會變成甚麼樣子?\r\n\r\n故事沒法在我的心底激起波瀾，那怕一絲，日記上的文字變得熟悉中帶點陌生，我記得當時自己寫下那些文字時眉飛色舞的神情，但我卻漸漸失去對情感的理解能力。\r\n\r\n我看著鏡中那張古井無波的臉，濃郁漆黑的恐懼蔓延，震顫著大腦。\r\n如今陪伴我的，還能讓我感受到「活著」的，只剩下恐懼。'),
(3, 3, '觀看 Youtube 影片之後的心得感想', '每過個十幾年，學界就會出現一個開天闢地的存在。\r\n當一個領域感覺已然山窮水盡，似乎就要觸及到極限時，人們總能發現一種全新看待問題的視角，找到另一個方向，從最早的專家系統到決策樹，向量機，再到近年的深度學習，Transformer。\r\n\r\n解決問題的方法大致可以分為兩種：分治法與端到端方法。\r\n分治法指的是將一個大問題切分成若干小問題，各自解決後再拼湊成完整的解決方案。\r\n例如，在開發自動駕駛系統時，分治法可能會將問題分解為車道保持、行人識別、障礙物避讓等小問題，然後各自解決這些小問題，最終組合成一個完整的系統。\r\n\r\n然而，分治法有其局限性。例如，自動駕駛AI需要在各種路況下做出最佳選擇，並且達到100%的準確度。使用分治法來實現這一點很難，因為面對的情況將近無限。解決大部分常見路況之後，想要進一步提升準確度，往往會變得非常困難且繁瑣。\r\n\r\n端到端方法則是給機器足夠多的數據，通過深度學習模型來自動學習如何處理各種情況。這種方法在處理複雜問題時往往能夠表現得更好，因為它能夠自動適應，學習從未見過的新情況。\r\n\r\n綜合以上，在面對複雜且多變的問題時，端到端方法可能更具優勢，這也是為甚麼自然語言處理會用端到端的方法去解決，因為語言的組合是無窮的。\r\n\r\n這樣看來，端到端算法很是神奇，給它資料，調些參數，模型就訓練好了，現在遇到的困境是甚麼呢? \r\n\r\n訓練人工智能，最終目的都是為了仿生。\r\n\r\n「人工智能產生超越人類的智慧，反過來支配了人類。」在這個時代已然不是一個新鮮的題材，而訓練出影視當中與常人無異的「機器人」，便是大多數人都想達成的里程碑。\r\n\r\n要做到這一點，首先要確保和它對話時不會中斷，而這也引出了一個問題，數據的傳輸。\r\n\r\n現在訓練一個語言模型，會花費大量時間在搬運數據上，和傳統的分治法不同，分治法解決小問題再拼起來，那些小問題互不相干，完全可以平行處理，在端到端的算法當中，每次都必須要將整塊丟入，得出一個結果，兩者都有搬運數據的問題，由於端到端本身的架構特性，這個問題被放大了。\r\n\r\n仿生仿的是人，答案就在我們的腦袋裡。\r\n\r\n人類的大腦不會花時間在搬運數據上，神經元同時扮演存儲和計算的功能，不需要搬運，大腦是存算一體的，更甚至連訓練都包含在內，時時更新。\r\n\r\n因此，未來的研究方向之一，便是如何實現存算一體的架構，徹底根治搬運數據的問題。\r\n\r\n假如做出了存算一體的架構，AI 便能夠大幅縮短溝通時的延遲 ( 以大語言模型為例)，現在 AI 能夠做到很多事情，但對各個專業領域的了解都比不上浸淫多年，對該領域了解深的人，如同一個基礎知識完備的大學生，缺乏對於單一領域的鑽研，但它是 AI，所以訓練的最終目標，自然就是一個全才，對於所有領域都深諳其道。\r\n\r\n怎麼壓縮信息? 是創造這個全才所需要的，必無可避的問題。\r\n\r\ninfinite context，是 google 最近發布的一篇論文，講述要怎麼將 AI 的 context 壓縮，騰出更多的空間給新的信息，隨著時間繼續向前走，將人類文明的所有知識壓縮進 AI 的大腦，並非不可能。\r\n\r\n人類積攢千年的知識塞進AI的「大腦」當中，它能夠做到自動駕駛、煮菜、提供心理諮詢，甚至教你微積分和英文，還能跟你打羽毛球，幫你寫文章，然後它的表現比你這個人類還要好，想像一下，一個存算一體的模型，它每分每秒都在自我進化，沒有人知道下一刻它會變成甚麼樣子，做出甚麼行動，這樣的模型，真的應該讓它存在嗎?\r\n\r\n當它成為了祂，人類該何去何從?\r\n...\r\n...\r\n撇開上面的問題，假如有這樣的一個模型，它會應用在甚麼方面呢?\r\n\r\n從小到大，你會遇到很多人，你的朋友、老師、同學、情人、親人、醫生... 等等，他們在你的人生中扮演不同的角色，你的同學同時是你的朋友，一個人可以扮演多個角色。\r\n\r\n現在有一個這樣全能的 AI，它可以扮演所有角色，那會變成甚麼樣的場景? 在遊戲當中每個 NPC 都是同一個模型去扮演的，實際上跟你交互的從頭到尾都是一個對象，搬到現實也是一樣的，那會是一個甚麼樣的光景?\r\n\r\n'),
(4, 4, '一篇關於最近地震頻發，看到很多新聞台說到重現期，但並沒有很好的說明這個概念，甚至有些是與正確觀念南轅北轍、錯誤百出，有感而發寫的一篇給地理人的入門統計文章。', '預測世間萬物的方法跟手段(或說典範)可以大致被分為兩種：\r\n- 基於物理的\r\n- 基於統計(機率)的\r\n\r\n基於物理的預測方法中，家喻戶曉的有像是預測空氣汙染會如何移動、聚集的空汙擴散模式。這種方式通常會利用電腦，去計算由一大堆微分方程所組成的物理模式。相當於是將現實世界以物理及數學的方式再現。\r\n\r\n而基於統計的預測方法中，同樣會以數學建構一個可以「對應」、連結兩個我們認為有關係的事物，並確定他們之間的量化關係，通常被視作是經驗型的數學模型。\r\n\r\n\r\n透過物理模式的預測方法比較直觀，但是基於機率的預測方式則比較難以理解。比如在經歷一場大雨後的河川水位高度(水深)預測上，就有兩種典範：\r\n- 定率水文學：測量總降雨量、依照地文條件選則合適的參數代入雨水轉流量的CN公式、獲得流量。\r\n- 序率水文學：統計過往每日的最大流量、將資料由小至大排序、經適宜性檢定後以隨機變數擬合、得到兩百年重現期流量。\r\n\r\n這裡提到了「重現期」這個名詞，他常常被用在基於機率的預測方法上。等等會詳細的說明。\r\n\r\n「淡水河兩百年重現期流量」，有些人可能會對這串文字有印象。他代表著一個數字，一個很大的流量，同時也是淡水河當年築堤的高度依據。\r\n但，說個小知識，其實當年蓋完淡水河堤防的幾年後就因為一場暴雨，從河堤內溢出大量河水，整個台北真的變得水洩不通。\r\n\r\n<h2>但為什麼？</h2>\r\n是因為蓋好的後的那年正逢兩百年重現期的洪水來臨嗎？可是兩百年重現期洪水應該要從什麼時候開始算兩百年？\r\n答案是沒有辦法從某個時候開始算兩百年重現期的。所以也自然就沒有辦法說出「今年有兩百年重現期的洪水，所以兩百年後也會有同樣的洪水。」，因為這是沒有邏輯、沒有意義的。\r\n講了這麼多，其實「200年重現期」中的200這個數字，並不是指「每幾年就會發生」，而是「每年有多少機率會發生」。這兩者是截然不同的意思。\r\n前者給出「一定會發生」的訊息，這是誤解。後者則是以機率的角度出發，給出一個每年有1/200的機率會發生。\r\n而會有「兩百年重現期」的這個描述字眼僅僅只是人類不喜歡說出每年有兩百分之一的機率會blablabla，所以換了一個說法，一個容易被人誤解的說法：\r\n既然每年會有兩百分之一的機率，它的倒數剛好是200，那我們就說是重現期200年吧。\r\n\r\n所以，當你下次看到「某某地震釋放的能量約為20年重現期」，並不是代表下一個20年一到就會發生差不多的地震。而是每年發生項這次這麼大的地震的機率約有1/20。\r\n\r\n<h2>註釋</h2>\r\n- 註1：比起「解釋」，在這裡應該要用「對應」一詞，才能比較好的詮釋經驗模型的本質。經驗型的模型不解釋原因，這就是為什麼統計的結果中，兩變量間具有相關性但不一定具因果性的原因。'),
(6, 7, '一個老水手回憶他年輕時在海上的冒險，講述大海盡頭那場永不忘記的落日。', 'ISBN：978-1-23456-789-0\r\n頁數：320頁\r\n字數：95,000字\r\n定價：$15.99\r\n出版日期：2024年5月20日'),
(7, 8, '一位老教授在自己的日記中記錄了他對未來的預言和回憶，探討時間的流動和記憶的力量。', 'ISBN：978-1-23456-789-1\r\n頁數：280頁\r\n字數：85,000字'),
(8, 9, '在長壽時代，如何在生活和工作中找到平衡和意義，幾位百歲老人的真實故事和經驗分享。', 'ISBN：978-1-23456-789-2\r\n頁數：350頁\r\n字數：105,000字'),
(9, 10, '一位教育心理學家剖析學習速度的原因，提供有效的學習策略和方法，幫助讀者提高學習效率。', 'ISBN：978-1-23456-789-3\r\n頁數：240頁\r\n字數：70,000字\r\n'),
(10, 11, '世界末日來臨，水火交織，一群倖存者在極端環境中奮力求生，揭示人性的黑暗與光明。', 'ISBN：978-1-23456-789-4\r\n頁數：400頁\r\n字數：120,000字'),
(11, 12, '太陽異常現象頻發，科學家們竭力調查真相，而一名記者偶然發現了背後的驚天陰謀。', 'ISBN：978-1-23456-789-5\r\n頁數：360頁\r\n字數：108,000字\r\n'),
(12, 13, '一個小鎮上，一場神秘的晚霞帶來了奇異的變化，居民們的內心深處漸漸產生了變化...', 'ISBN：978-1-23456-789-6\r\n頁數：250頁\r\n字數：75,000字\r\n'),
(13, 14, '一名心理醫生與他的病人進行了一場場深刻的對話，逐漸揭開了一個埋藏已久的驚天秘密。', 'ISBN：978-1-23456-789-8\r\n頁數：280頁\r\n字數：84,000字'),
(14, 15, '一隻神秘的貓進入了一個普通家庭，帶來了一系列奇妙的事件和驚喜。', 'ISBN：978-1-23456-789-7\r\n頁數：220頁\r\n字數：66,000字'),
(15, 16, '醫生記錄了一系列奇怪病例，從中揭示了人性的複雜與社會的多面。這些病例跨越了心理和生理的界限，每一個都蘊含著深刻的生命故事和哲理。', 'ISBN：978-1-23456-781-4\r\n頁數：320頁\r\n字數：96,000字'),
(16, 17, '在一個罪惡橫行的城市中，一位名為“弒罪人”的神秘人物出現，開始獵殺那些法網難以制裁的罪犯。這是一場關於正義與復仇的對決，每一步都充滿了驚險和謎團。', 'ISBN：978-1-23456-782-4\r\n頁數：380頁\r\n字數：114,000字'),
(17, 18, '通過一系列深刻的社會觀察，揭示當代社會的矛盾與衝突，並試圖探索解決方案。', 'ISBN：978-1-23456-782-5\r\n頁數：300頁\r\n字數：90,000字'),
(18, 19, '每一件古董都有自己的故事，這本書通過對古董的描述，帶領讀者走進歷史的長河。', 'ISBN：978-1-23456-782-6\r\n頁數：280頁\r\n字數：84,000字'),
(19, 20, '創作了一個虛構的帝國，描述其興衰歷程，通過虛構歷史反映現實社會的問題和思考。', 'ISBN：978-1-23456-782-7\r\n頁數：320頁\r\n字數：96,000字'),
(20, 21, '在動亂的時代，兩個來自不同背景的人相遇，這部作品通過他們的故事，揭示了戰爭與和平、仇恨與友誼的多重意涵。', 'ISBN：978-1-23456-783-2\r\n頁數：360頁\r\n字數：108,000字'),
(21, 22, '記錄了作者在各地古墓探險的經歷，揭示了古墓中的神秘和驚險，帶領讀者一起探索未知的世界。', 'ISBN：978-1-23456-783-3\r\n頁數：320頁\r\n字數：96,000字'),
(22, 23, '回顧歷史上那些改變世界的事件和人物，通過生動的敘述將歷史再現，帶領讀者穿越時空。', 'ISBN：978-1-23456-783-8\r\n頁數：380頁\r\n字數：114,000字'),
(23, 24, '一場盛大的煙花表演背後，牽扯出一段古老而動人的歷史故事，揭示了傳統文化的魅力。煙花絢爛如火樹銀花，每一顆閃亮的煙火都講述著一個歷史片段和其中的愛恨情仇。', 'ISBN：978-1-23456-783-9\r\n頁數：300頁\r\n字數：90,000字'),
(24, 25, '在一個神秘的湖泊邊，波光粼粼的水面下隱藏著一段淒美的愛情故事。一位藝術家在湖畔創作時，偶然間發現了這段被遺忘的故事，隨著探尋，他的畫作也開始蘊含奇異的力量。這是一個關於愛情、藝術與靈魂的迷人傳說。', 'ISBN：978-1-23456-784-0\r\n頁數：320頁\r\n字數：96,000字'),
(25, 26, '在古老的江湖中，臨光是一門失傳已久的絕世武功，傳說中掌握此功者可與天地同壽，驅動光影，無敵於世。主角是一名孤獨的劍客，他因偶然機緣得到了臨光的秘笈，卻也因此捲入了江湖的腥風血雨。隨著故事的展開，主人公在愛恨情仇中成長，最終領悟了臨光的真諦。這是一部充滿動作、冒險和深情的武俠小說。\r\n\r\n', 'ISBN：978-1-23456-784-2\r\n頁數：420頁\r\n字數：126,000字'),
(26, 27, '一股強大的邪惡力量，凋零風暴，席捲了整個方塊大陸!\r\n一位勇敢的玩家站出來，他與好友們為了從這股黑暗勢力當中保護世界。\r\n組成了強悍的冒險隊穿越重重險境，誓言要在這片充滿危險的世界中闖出一片天。面對凋零風暴的肆虐，他們將穿越險惡的地形，擊敗強大的敵人，收集傳說中的神器，在絕望的深淵中尋找勝利的希望。這是一段充滿熱血、友情與戰鬥的史詩冒險故事\r\n這是一段關於勇氣、友誼和戰鬥的史詩冒險故事!\r\n\r\n', 'ISBN：978-1-23456-784-3\r\n頁數：350頁\r\n字數：105,000字'),
(27, 28, '在一個充滿鬥爭與混亂的江湖中，燃燒的種子象徵著一股新生的力量。主角是一名少年，他的家園被敵人摧毀，為了復仇和重建家園，他踏上了一條艱難的成長之路。通過不斷地鍛煉和挑戰，他在風雨中成長為一個頂天立地的英雄。這是一個關於勇氣、信念與堅持的熱血故事，每一頁都燃燒著不屈的精神和無盡的希望。', 'ISBN：978-1-23456-784-4\r\n頁數：380頁\r\n字數：114,000字'),
(28, 29, '玉簪斷，錦書難寄，夜深夢覺愁幾許；\r\n孤燈冷，窗影淺淡，星稀雲疏月如故。\r\n\r\n在煙雨朦朧的江南，一位年輕的俠客與一名才女因緣際會，兩人相識於詩詞唱和之中，卻因江湖恩怨而被迫分離。這段相思之情如同古詩般悠長，縈繞於兩人的心間。俠客縱橫江湖，只為再見伊人，才女獨守孤城，筆墨為情，每一句詩詞，都承載著無盡的思念與期盼。\r\n\r\n萬里江湖，波濤如雪，劍影詩魂共舞；\r\n玉笛聲遠，心隨雁飛，英雄寂寞情苦。', 'ISBN：978-1-23456-784-5\r\n頁數：300頁\r\n字數：90,000字'),
(29, 30, '<h3>什麼是知識蒸餾(K.D.)？</h3>\r\n知識蒸餾的原文是 knowledge distillation。\r\n這項技術當初是被發表在一篇關於模型壓縮的論文上面。\r\n透過這項技術，甚至可以讓更小、參數量更少的模型(student model)，擁有跟老師模型(teacher model)幾乎同樣，甚至更好的performance。\r\n\r\n當然，模型壓縮的方法非常多樣，有像是直接將神經元(也就是權重)剃除的 pruning、有將權重的精準度從 float32 quantify(量化)成 int16 的量化方式、\r\n有針對卷積層設計的另一種卷積演算法，可以降低卷積參數量甚至在準確度上達到更好的 performance。最後就是讀書人的剽竊神功：知識蒸餾(KD)。\r\n\r\n<h3>讀書人的事，能叫偷嗎？</h3>\r\n讀書人的事，能叫偷嗎？隨後便是一連串損失函數的名稱，之乎者也的……\r\n知識蒸餾的概念是研究人員為了改進語言模型的一個缺失而產生的想法：模型越蓋越大我們能不能讓小模型去模仿大模型的輸出，藉此減少參數量、去除parameter-wised overfitting、精煉訊息的representation、卻仍能夠有差不多的預測performance。研究人員最後提出的作法跟 soft label 這個方法很相似，不過因為 KD 的 loss function 的設計讓這套做法獨樹一格、自成一家。\r\n\r\n<h3>知識蒸餾的概念</h3>\r\n這裡會將內容專注在「為什麼知識蒸餾是有效的」以及「為什麼他可以是有效的？」。\r\n比較底層的實作概念以及一些實作重點，也就是「如何去實作知識蒸餾的底層」，礙於篇幅，會在後續篇章講解。\r\n\r\n首先為什麼知識蒸餾是有效的？首先我們都知道，比起 hard label，也就是在分類的 target label 陣列中，所有的 element 是非 0 即 1 的數字。\r\nsoft label 對於最後一層是 softmax 或是 sigmoid(logistic) 作為 activation function 的模型會比較好學習。因為，想像今天模型的最後一層權重想要輸出一個「經過 sigmoid 後為 1 的數值」，那麼這層權重就需要在經過 sigmoid 之前，將每個輸入乘上其對應的權重，並相加產出一個超級大的數值，以便這個數值在經過(代入) sigmoid 之後可以產出1。\r\n那麼上面提到的這個數值是多少呢？答案是無限大。只有在 x 趨近於無限大的時候，1 / (1 + e^(-x) ) 才會是 1/1。\r\n那麼從模型的角度來說，訓練出一些絕對值非常大的權重可以被視作是一種 overfitting。所以，如果是二元分類的話，我們可以將原本的 label 從 0 改為 0.1，從 1 改為 0.9。\r\n那麼原本需要學出無限大的權重，現在只需要產出的數字是 -3 左右，在經過 sigmoid 之後就會有大約是 0.1 (符合原本為 0 的 label)的結果。\r\n\r\n看來我們已經改善了模型在學習上的難易程度。\r\n而在上面我們僅僅只是手工調整 label 的數值，可不可能，其實標籤中不同的「數值」可以隱含著更多的資訊呢？我們可以用一些科學手段，讓標籤的數值具備一些物理意涵嗎？\r\n如果我們可以做到這點，那麼提供給模型的學習資訊就不僅僅只是「這張圖片是這個類別、這張不是這個類別」的資訊，而可能像是「這張圖片中有一些這個類別、這張圖片有一些那個類別的特徵、圖片中這個類別的特徵比其他的都要較多」。\r\n\r\n那我們要怎麼有系統的、科學的，或是能夠做到這件事？因為對人類而言，如果我們要將一張圖片分類到五個類別裡面(比如說貓、魚……)，一張圖片只有「是貓」、「是馬」、「是魚」等等，這幾種選項，應該沒有人可以回答出這張圖片有幾%是魚(符合魚的特徵)、有幾%是馬。可以的話也沒有一個公認的答案(比如說37%)。\r\n所以我們需要模型來幫我們給出這個答案(中間答案)。\r\n邏輯推理一下，因為如果一個模型本身可以分出正確的類別，那麼代表他對於每個類別的特徵有足夠的理解。所以我們應該可以將它的輸出視作是屬於該類別的機率，即有多少程度是符合這個類別的。\r\n(對於影像的二分類而言，就算我們可以。所以其實在多分類的 task 上更能體現 KD 的強大威力。)\r\n\r\n這樣結果會是好的嗎？這樣不會混淆模型嗎？這樣不是更難學嗎？其實透過 KD 訓練的模型在預測的表現上可能不比大模型還要差！\r\n好吧，看來今天網路用得夠多了，我們會後續再討論關於知識蒸餾的底層實踐，喔對然後我們會用 pytorch 。', '【圖書資訊】\r\n頁數：1 頁\r\n出版社：彰師大資工系\r\nISBN：04-7232105\r\n\r\n\r\n推薦序：\r\n【國立彰化師範大學校長 ─ 程鳴輝】：拜讀之後如當頭棒喝，竟然可以有如此精闢的見解。其中對於「空」這個概念的探討深入淺出、對於何謂「好學」的定意一針見血。\r\n【國立彰化師範大學教授 ─ 程白月】：這位同學的心得一看就是不是用背的，都是用想的。你看用想的就很有趣！不要像那些歷史地理系的一樣啊！');

-- --------------------------------------------------------

--
-- 資料表結構 `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(4, 2, 'https://images.pexels.com/photos/1029141/pexels-photo-1029141.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(5, 3, 'https://images.pexels.com/photos/8386440/pexels-photo-8386440.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(6, 7, 'https://images.pexels.com/photos/189349/pexels-photo-189349.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(7, 27, 'https://static.wikia.nocookie.net/minecraft/images/9/9e/Wither_Storm_in_png_.png/revision/latest?cb=20200426035200'),
(8, 8, 'https://images.pexels.com/photos/1102937/pexels-photo-1102937.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(9, 22, 'https://images.pexels.com/photos/1121906/pexels-photo-1121906.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(10, 19, 'https://images.pexels.com/photos/612800/pexels-photo-612800.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(11, 15, 'https://images.pexels.com/photos/20787/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(12, 17, 'https://images.pexels.com/photos/3309865/pexels-photo-3309865.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(13, 12, 'https://images.pexels.com/photos/147465/pexels-photo-147465.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(14, 13, 'https://images.pexels.com/photos/814449/pexels-photo-814449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(15, 23, 'https://images.pexels.com/photos/20270117/pexels-photo-20270117.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'),
(16, 24, 'https://images.unsplash.com/photo-1533219057257-4bb9ed5d2cc6?q=80&w=1287&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(17, 11, 'https://images.unsplash.com/photo-1621423028742-e6f7256405d8?q=80&w=1287&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(18, 25, 'https://images.unsplash.com/photo-1554779147-a2a22d816042?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(19, 25, 'https://images.unsplash.com/photo-1528482158551-6bad580f8330?q=80&w=1287&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(20, 10, 'https://images.unsplash.com/photo-1617440168937-c6497eaa8db5?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(21, 28, 'https://images.unsplash.com/photo-1461484261293-7175bb44e871?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'),
(22, 16, 'https://images.unsplash.com/photo-1534289855405-ab820a118fc1?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_phone` (`phone`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- 資料表索引 `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- 資料表索引 `product_comment`
--
ALTER TABLE `product_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 資料表索引 `product_contents`
--
ALTER TABLE `product_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 資料表索引 `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_comment`
--
ALTER TABLE `product_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_contents`
--
ALTER TABLE `product_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

--
-- 資料表的限制式 `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `product_comment`
--
ALTER TABLE `product_comment`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- 資料表的限制式 `product_contents`
--
ALTER TABLE `product_contents`
  ADD CONSTRAINT `product_contents_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- 資料表的限制式 `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
