-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 15, 2025 lúc 04:38 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mytodo`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `description`, `due_date`, `status`, `priority`, `created_at`) VALUES
(2, 1, 'Viết báo cáo tuần', 'Hoàn thiện phần phân tích và tổng hợp dữ liệu cho báo cáo tuần. Gửi trước thứ Hai.', '2015-11-27', 'pending', 'medium', '2025-11-14 15:24:48'),
(3, 1, 'Tập thể dục ngoài trời', 'Chạy bộ 30 phút + bài tập cơ bản, chuẩn bị cho giải chạy cuối tháng.', '2025-11-18', 'completed', 'medium', '2025-11-14 15:28:48'),
(5, 2, 'Họp với khách hàng', 'Gặp khách để thảo luận về yêu cầu mới', '2025-11-12', 'in_progress', 'medium', '2025-11-14 16:08:36'),
(6, 3, 'Học Toán', 'Toán cao cấp1,2', '2024-09-27', 'completed', 'medium', '2025-11-14 23:33:06'),
(8, 3, 'Làm bài luận', 'Bài luận tốt nghiệp', '2026-04-29', 'pending', 'medium', '2025-11-14 23:34:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'Pham Thanh', '$2y$10$NgmZ..l4qPbz9kuy6RrKLuAUIT7Om0OvR6Ui8t81Mu64vLuc75z22', 'thanhpa@gmail.com', '2025-11-14 14:38:01'),
(2, 'Tran Hong', '$2y$10$DZ.76GjLoo2ugrsS.U5DKuceajvKJELEmcdf6F3lRY6f7bfHfvF6.', 'hong9@gmail.com', '2025-11-14 15:48:21'),
(3, 'Thuy Nguyen', '$2y$10$zxYeHHFWtHlqUKP6puZne.hXYol.XX.y3BPQnbrb.lJIPuJ6mYHGG', 'thuyng@gmail.com', '2025-11-14 23:31:42');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
