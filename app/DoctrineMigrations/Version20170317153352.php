<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170317153352 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("INSERT INTO `acl_classes` (`id`, `class_type`) VALUES
            (2, 'Sitioweb\\\\Bundle\\\\ArmyCreatorBundle\\\\Entity\\\\Breed'),
            (1, 'Sitioweb\\\\Bundle\\\\ArmyCreatorBundle\\\\Entity\\\\Game')");

        $this->addSql("INSERT INTO acl_security_identities (id, username, identifier) VALUES (1, 0, 'ROLE_ADMIN')");
        $this->addSql("INSERT INTO acl_security_identities (id, username, identifier) VALUES (2, 0, 'ROLE_ADMIN_CONTRIB_ALL')");
        $this->addSql("INSERT INTO acl_security_identities (id, username, identifier) VALUES (3, 0, 'ROLE_CONTRIB')");

        $this->addSql("
            INSERT INTO `acl_entries` (`id`, `class_id`, `object_identity_id`, `security_identity_id`, `field_name`, `ace_order`, `mask`, `granting`, `granting_strategy`, `audit_success`, `audit_failure`) VALUES
(445, 2, NULL, 3, NULL, 0, 1, 1, 'all', 0, 0),
(444, 2, NULL, 2, NULL, 1, 4, 1, 'all', 0, 0),
(443, 2, NULL, 1, NULL, 2, 32, 1, 'all', 0, 0),
(442, 2, NULL, 3, NULL, 3, 1, 1, 'all', 0, 0),
(441, 2, NULL, 2, NULL, 4, 4, 1, 'all', 0, 0),
(440, 2, NULL, 1, NULL, 5, 32, 1, 'all', 0, 0),
(439, 1, NULL, 3, NULL, 0, 1, 1, 'all', 0, 0),
(438, 1, NULL, 2, NULL, 1, 4, 1, 'all', 0, 0),
(437, 1, NULL, 1, NULL, 2, 32, 1, 'all', 0, 0),
(436, 2, NULL, 3, NULL, 6, 1, 1, 'all', 0, 0),
(435, 2, NULL, 2, NULL, 7, 4, 1, 'all', 0, 0),
(434, 2, NULL, 1, NULL, 8, 32, 1, 'all', 0, 0),
(433, 2, NULL, 3, NULL, 9, 1, 1, 'all', 0, 0),
(432, 2, NULL, 2, NULL, 10, 4, 1, 'all', 0, 0),
(431, 2, NULL, 1, NULL, 11, 32, 1, 'all', 0, 0),
(430, 2, NULL, 3, NULL, 12, 1, 1, 'all', 0, 0),
(429, 2, NULL, 2, NULL, 13, 4, 1, 'all', 0, 0),
(428, 2, NULL, 1, NULL, 14, 32, 1, 'all', 0, 0),
(427, 1, NULL, 3, NULL, 3, 1, 1, 'all', 0, 0),
(426, 1, NULL, 2, NULL, 4, 4, 1, 'all', 0, 0),
(425, 1, NULL, 1, NULL, 5, 32, 1, 'all', 0, 0),
(424, 2, NULL, 3, NULL, 15, 1, 1, 'all', 0, 0),
(423, 2, NULL, 2, NULL, 16, 4, 1, 'all', 0, 0),
(422, 2, NULL, 1, NULL, 17, 32, 1, 'all', 0, 0),
(420, 2, NULL, 3, NULL, 18, 1, 1, 'all', 0, 0),
(419, 2, NULL, 2, NULL, 19, 4, 1, 'all', 0, 0),
(418, 2, NULL, 1, NULL, 20, 32, 1, 'all', 0, 0),
(415, 2, NULL, 3, NULL, 21, 1, 1, 'all', 0, 0),
(414, 2, NULL, 2, NULL, 22, 4, 1, 'all', 0, 0),
(413, 2, NULL, 1, NULL, 23, 32, 1, 'all', 0, 0),
(412, 2, NULL, 3, NULL, 24, 1, 1, 'all', 0, 0),
(411, 2, NULL, 2, NULL, 25, 4, 1, 'all', 0, 0),
(410, 2, NULL, 1, NULL, 26, 32, 1, 'all', 0, 0),
(409, 2, NULL, 3, NULL, 27, 1, 1, 'all', 0, 0),
(408, 2, NULL, 2, NULL, 28, 4, 1, 'all', 0, 0),
(407, 2, NULL, 1, NULL, 29, 32, 1, 'all', 0, 0),
(406, 2, NULL, 3, NULL, 30, 1, 1, 'all', 0, 0),
(405, 2, NULL, 2, NULL, 31, 4, 1, 'all', 0, 0),
(404, 2, NULL, 1, NULL, 32, 32, 1, 'all', 0, 0),
(403, 1, NULL, 3, NULL, 6, 1, 1, 'all', 0, 0),
(402, 1, NULL, 2, NULL, 7, 4, 1, 'all', 0, 0),
(401, 1, NULL, 1, NULL, 8, 32, 1, 'all', 0, 0),
(400, 2, NULL, 3, NULL, 33, 1, 1, 'all', 0, 0),
(399, 2, NULL, 2, NULL, 34, 4, 1, 'all', 0, 0),
(398, 2, NULL, 1, NULL, 35, 32, 1, 'all', 0, 0),
(397, 2, NULL, 3, NULL, 36, 1, 1, 'all', 0, 0),
(396, 2, NULL, 2, NULL, 37, 4, 1, 'all', 0, 0),
(395, 2, NULL, 1, NULL, 38, 32, 1, 'all', 0, 0),
(394, 2, NULL, 3, NULL, 39, 1, 1, 'all', 0, 0),
(393, 2, NULL, 2, NULL, 40, 4, 1, 'all', 0, 0),
(392, 2, NULL, 1, NULL, 41, 32, 1, 'all', 0, 0),
(391, 2, NULL, 3, NULL, 42, 1, 1, 'all', 0, 0),
(390, 2, NULL, 2, NULL, 43, 4, 1, 'all', 0, 0),
(389, 2, NULL, 1, NULL, 44, 32, 1, 'all', 0, 0),
(388, 2, NULL, 3, NULL, 45, 1, 1, 'all', 0, 0),
(387, 2, NULL, 2, NULL, 46, 4, 1, 'all', 0, 0),
(386, 2, NULL, 1, NULL, 47, 32, 1, 'all', 0, 0),
(385, 2, NULL, 3, NULL, 48, 1, 1, 'all', 0, 0),
(384, 2, NULL, 2, NULL, 49, 4, 1, 'all', 0, 0),
(383, 2, NULL, 1, NULL, 50, 32, 1, 'all', 0, 0),
(382, 2, NULL, 3, NULL, 51, 1, 1, 'all', 0, 0),
(381, 2, NULL, 2, NULL, 52, 4, 1, 'all', 0, 0),
(380, 2, NULL, 1, NULL, 53, 32, 1, 'all', 0, 0),
(379, 2, NULL, 3, NULL, 54, 1, 1, 'all', 0, 0),
(378, 2, NULL, 2, NULL, 55, 4, 1, 'all', 0, 0),
(377, 2, NULL, 1, NULL, 56, 32, 1, 'all', 0, 0),
(376, 2, NULL, 3, NULL, 57, 1, 1, 'all', 0, 0),
(375, 2, NULL, 2, NULL, 58, 4, 1, 'all', 0, 0),
(374, 2, NULL, 1, NULL, 59, 32, 1, 'all', 0, 0),
(373, 1, NULL, 3, NULL, 9, 1, 1, 'all', 0, 0),
(372, 1, NULL, 2, NULL, 10, 4, 1, 'all', 0, 0),
(371, 1, NULL, 1, NULL, 11, 32, 1, 'all', 0, 0),
(369, 2, NULL, 3, NULL, 60, 1, 1, 'all', 0, 0),
(368, 2, NULL, 2, NULL, 61, 4, 1, 'all', 0, 0),
(367, 2, NULL, 1, NULL, 62, 32, 1, 'all', 0, 0),
(365, 2, NULL, 3, NULL, 63, 1, 1, 'all', 0, 0),
(364, 2, NULL, 2, NULL, 64, 4, 1, 'all', 0, 0),
(363, 2, NULL, 1, NULL, 65, 32, 1, 'all', 0, 0),
(356, 2, NULL, 3, NULL, 66, 1, 1, 'all', 0, 0),
(355, 2, NULL, 2, NULL, 67, 4, 1, 'all', 0, 0),
(354, 2, NULL, 1, NULL, 68, 32, 1, 'all', 0, 0),
(349, 2, NULL, 3, NULL, 69, 1, 1, 'all', 0, 0),
(348, 2, NULL, 2, NULL, 70, 4, 1, 'all', 0, 0),
(347, 2, NULL, 1, NULL, 71, 32, 1, 'all', 0, 0),
(346, 2, NULL, 3, NULL, 72, 1, 1, 'all', 0, 0),
(345, 2, NULL, 2, NULL, 73, 4, 1, 'all', 0, 0),
(344, 2, NULL, 1, NULL, 74, 32, 1, 'all', 0, 0),
(343, 2, NULL, 3, NULL, 75, 1, 1, 'all', 0, 0),
(342, 2, NULL, 2, NULL, 76, 4, 1, 'all', 0, 0),
(341, 2, NULL, 1, NULL, 77, 32, 1, 'all', 0, 0),
(340, 2, NULL, 3, NULL, 78, 1, 1, 'all', 0, 0),
(339, 2, NULL, 2, NULL, 79, 4, 1, 'all', 0, 0),
(338, 2, NULL, 1, NULL, 80, 32, 1, 'all', 0, 0),
(333, 2, NULL, 3, NULL, 81, 1, 1, 'all', 0, 0),
(332, 2, NULL, 2, NULL, 82, 4, 1, 'all', 0, 0),
(331, 2, NULL, 1, NULL, 83, 32, 1, 'all', 0, 0),
(330, 2, NULL, 3, NULL, 84, 1, 1, 'all', 0, 0),
(329, 2, NULL, 2, NULL, 85, 4, 1, 'all', 0, 0),
(328, 2, NULL, 1, NULL, 86, 32, 1, 'all', 0, 0),
(326, 2, NULL, 3, NULL, 87, 1, 1, 'all', 0, 0),
(325, 2, NULL, 2, NULL, 88, 4, 1, 'all', 0, 0),
(324, 2, NULL, 1, NULL, 89, 32, 1, 'all', 0, 0),
(321, 2, NULL, 3, NULL, 90, 1, 1, 'all', 0, 0),
(320, 2, NULL, 2, NULL, 91, 4, 1, 'all', 0, 0),
(319, 2, NULL, 1, NULL, 92, 32, 1, 'all', 0, 0),
(316, 2, NULL, 3, NULL, 93, 1, 1, 'all', 0, 0),
(315, 2, NULL, 2, NULL, 94, 4, 1, 'all', 0, 0),
(314, 2, NULL, 1, NULL, 95, 32, 1, 'all', 0, 0),
(310, 2, NULL, 3, NULL, 96, 1, 1, 'all', 0, 0),
(309, 2, NULL, 2, NULL, 97, 4, 1, 'all', 0, 0),
(308, 2, NULL, 1, NULL, 98, 32, 1, 'all', 0, 0),
(304, 1, NULL, 3, NULL, 12, 1, 1, 'all', 0, 0),
(303, 1, NULL, 2, NULL, 13, 4, 1, 'all', 0, 0),
(302, 1, NULL, 1, NULL, 14, 32, 1, 'all', 0, 0),
(300, 2, NULL, 3, NULL, 99, 1, 1, 'all', 0, 0),
(299, 2, NULL, 2, NULL, 100, 4, 1, 'all', 0, 0),
(298, 2, NULL, 1, NULL, 101, 32, 1, 'all', 0, 0),
(292, 2, NULL, 3, NULL, 102, 1, 1, 'all', 0, 0),
(291, 2, NULL, 2, NULL, 103, 4, 1, 'all', 0, 0),
(290, 2, NULL, 1, NULL, 104, 32, 1, 'all', 0, 0),
(285, 2, NULL, 3, NULL, 105, 1, 1, 'all', 0, 0),
(284, 2, NULL, 2, NULL, 106, 4, 1, 'all', 0, 0),
(283, 2, NULL, 1, NULL, 107, 32, 1, 'all', 0, 0),
(281, 2, NULL, 3, NULL, 108, 1, 1, 'all', 0, 0),
(280, 2, NULL, 2, NULL, 109, 4, 1, 'all', 0, 0),
(279, 2, NULL, 1, NULL, 110, 32, 1, 'all', 0, 0),
(272, 2, NULL, 3, NULL, 111, 1, 1, 'all', 0, 0),
(271, 2, NULL, 2, NULL, 112, 4, 1, 'all', 0, 0),
(270, 2, NULL, 1, NULL, 113, 32, 1, 'all', 0, 0),
(269, 2, NULL, 3, NULL, 114, 1, 1, 'all', 0, 0),
(268, 2, NULL, 2, NULL, 115, 4, 1, 'all', 0, 0),
(267, 2, NULL, 1, NULL, 116, 32, 1, 'all', 0, 0),
(266, 2, NULL, 3, NULL, 117, 1, 1, 'all', 0, 0),
(265, 2, NULL, 2, NULL, 118, 4, 1, 'all', 0, 0),
(264, 2, NULL, 1, NULL, 119, 32, 1, 'all', 0, 0),
(263, 1, NULL, 3, NULL, 15, 1, 1, 'all', 0, 0),
(262, 1, NULL, 2, NULL, 16, 4, 1, 'all', 0, 0),
(261, 1, NULL, 1, NULL, 17, 32, 1, 'all', 0, 0),
(260, 1, NULL, 3, NULL, 18, 1, 1, 'all', 0, 0),
(259, 1, NULL, 2, NULL, 19, 4, 1, 'all', 0, 0),
(258, 1, NULL, 1, NULL, 20, 32, 1, 'all', 0, 0),
(257, 2, NULL, 3, NULL, 120, 1, 1, 'all', 0, 0),
(256, 2, NULL, 2, NULL, 121, 4, 1, 'all', 0, 0),
(255, 2, NULL, 1, NULL, 122, 32, 1, 'all', 0, 0),
(254, 2, NULL, 3, NULL, 123, 1, 1, 'all', 0, 0),
(253, 2, NULL, 2, NULL, 124, 4, 1, 'all', 0, 0),
(252, 2, NULL, 1, NULL, 125, 32, 1, 'all', 0, 0),
(250, 2, NULL, 3, NULL, 126, 1, 1, 'all', 0, 0),
(249, 2, NULL, 2, NULL, 127, 4, 1, 'all', 0, 0),
(248, 2, NULL, 1, NULL, 128, 32, 1, 'all', 0, 0),
(246, 2, NULL, 3, NULL, 129, 1, 1, 'all', 0, 0),
(245, 2, NULL, 2, NULL, 130, 4, 1, 'all', 0, 0),
(244, 2, NULL, 1, NULL, 131, 32, 1, 'all', 0, 0),
(234, 2, NULL, 3, NULL, 132, 1, 1, 'all', 0, 0),
(233, 2, NULL, 2, NULL, 133, 4, 1, 'all', 0, 0),
(232, 2, NULL, 1, NULL, 134, 32, 1, 'all', 0, 0),
(231, 2, NULL, 3, NULL, 135, 1, 1, 'all', 0, 0),
(230, 2, NULL, 2, NULL, 136, 4, 1, 'all', 0, 0),
(229, 2, NULL, 1, NULL, 137, 32, 1, 'all', 0, 0),
(228, 2, NULL, 3, NULL, 138, 1, 1, 'all', 0, 0),
(227, 2, NULL, 2, NULL, 139, 4, 1, 'all', 0, 0),
(226, 2, NULL, 1, NULL, 140, 32, 1, 'all', 0, 0),
(225, 2, NULL, 3, NULL, 141, 1, 1, 'all', 0, 0),
(224, 2, NULL, 2, NULL, 142, 4, 1, 'all', 0, 0),
(223, 2, NULL, 1, NULL, 143, 32, 1, 'all', 0, 0),
(222, 2, NULL, 3, NULL, 144, 1, 1, 'all', 0, 0),
(221, 2, NULL, 2, NULL, 145, 4, 1, 'all', 0, 0),
(220, 2, NULL, 1, NULL, 146, 32, 1, 'all', 0, 0),
(219, 2, NULL, 3, NULL, 147, 1, 1, 'all', 0, 0),
(218, 2, NULL, 2, NULL, 148, 4, 1, 'all', 0, 0),
(217, 2, NULL, 1, NULL, 149, 32, 1, 'all', 0, 0),
(216, 2, NULL, 3, NULL, 150, 1, 1, 'all', 0, 0),
(215, 2, NULL, 2, NULL, 151, 4, 1, 'all', 0, 0),
(214, 2, NULL, 1, NULL, 152, 32, 1, 'all', 0, 0),
(213, 2, NULL, 3, NULL, 153, 1, 1, 'all', 0, 0),
(212, 2, NULL, 2, NULL, 154, 4, 1, 'all', 0, 0),
(211, 2, NULL, 1, NULL, 155, 32, 1, 'all', 0, 0),
(210, 2, NULL, 3, NULL, 156, 1, 1, 'all', 0, 0),
(209, 2, NULL, 2, NULL, 157, 4, 1, 'all', 0, 0),
(208, 2, NULL, 1, NULL, 158, 32, 1, 'all', 0, 0),
(207, 1, NULL, 3, NULL, 21, 1, 1, 'all', 0, 0),
(206, 1, NULL, 2, NULL, 22, 4, 1, 'all', 0, 0),
(205, 1, NULL, 1, NULL, 23, 32, 1, 'all', 0, 0),
(187, 2, NULL, 3, NULL, 159, 1, 1, 'all', 0, 0),
(186, 2, NULL, 2, NULL, 160, 4, 1, 'all', 0, 0),
(185, 2, NULL, 1, NULL, 161, 32, 1, 'all', 0, 0),
(183, 2, NULL, 3, NULL, 162, 1, 1, 'all', 0, 0),
(182, 2, NULL, 2, NULL, 163, 4, 1, 'all', 0, 0),
(181, 2, NULL, 1, NULL, 164, 32, 1, 'all', 0, 0),
(180, 2, NULL, 3, NULL, 165, 1, 1, 'all', 0, 0),
(179, 2, NULL, 2, NULL, 166, 4, 1, 'all', 0, 0),
(178, 2, NULL, 1, NULL, 167, 32, 1, 'all', 0, 0),
(177, 2, NULL, 3, NULL, 168, 1, 1, 'all', 0, 0),
(176, 2, NULL, 2, NULL, 169, 4, 1, 'all', 0, 0),
(175, 2, NULL, 1, NULL, 170, 32, 1, 'all', 0, 0),
(174, 2, NULL, 3, NULL, 171, 1, 1, 'all', 0, 0),
(173, 2, NULL, 2, NULL, 172, 4, 1, 'all', 0, 0),
(172, 2, NULL, 1, NULL, 173, 32, 1, 'all', 0, 0),
(171, 2, NULL, 3, NULL, 174, 1, 1, 'all', 0, 0),
(170, 2, NULL, 2, NULL, 175, 4, 1, 'all', 0, 0),
(169, 2, NULL, 1, NULL, 176, 32, 1, 'all', 0, 0),
(168, 2, NULL, 3, NULL, 177, 1, 1, 'all', 0, 0),
(167, 2, NULL, 2, NULL, 178, 4, 1, 'all', 0, 0),
(166, 2, NULL, 1, NULL, 179, 32, 1, 'all', 0, 0),
(165, 2, NULL, 3, NULL, 180, 1, 1, 'all', 0, 0),
(164, 2, NULL, 2, NULL, 181, 4, 1, 'all', 0, 0),
(163, 2, NULL, 1, NULL, 182, 32, 1, 'all', 0, 0),
(162, 2, NULL, 3, NULL, 183, 1, 1, 'all', 0, 0),
(161, 2, NULL, 2, NULL, 184, 4, 1, 'all', 0, 0),
(160, 2, NULL, 1, NULL, 185, 32, 1, 'all', 0, 0),
(159, 2, NULL, 3, NULL, 186, 1, 1, 'all', 0, 0),
(158, 2, NULL, 2, NULL, 187, 4, 1, 'all', 0, 0),
(157, 2, NULL, 1, NULL, 188, 32, 1, 'all', 0, 0),
(156, 2, NULL, 3, NULL, 189, 1, 1, 'all', 0, 0),
(155, 2, NULL, 2, NULL, 190, 4, 1, 'all', 0, 0),
(154, 2, NULL, 1, NULL, 191, 32, 1, 'all', 0, 0),
(153, 2, NULL, 3, NULL, 192, 1, 1, 'all', 0, 0),
(152, 2, NULL, 2, NULL, 193, 4, 1, 'all', 0, 0),
(151, 2, NULL, 1, NULL, 194, 32, 1, 'all', 0, 0),
(150, 2, NULL, 3, NULL, 195, 1, 1, 'all', 0, 0),
(149, 2, NULL, 2, NULL, 196, 4, 1, 'all', 0, 0),
(148, 2, NULL, 1, NULL, 197, 32, 1, 'all', 0, 0),
(147, 2, NULL, 3, NULL, 198, 1, 1, 'all', 0, 0),
(146, 2, NULL, 2, NULL, 199, 4, 1, 'all', 0, 0),
(145, 2, NULL, 1, NULL, 200, 32, 1, 'all', 0, 0),
(144, 2, NULL, 3, NULL, 201, 1, 1, 'all', 0, 0),
(143, 2, NULL, 2, NULL, 202, 4, 1, 'all', 0, 0),
(142, 2, NULL, 1, NULL, 203, 32, 1, 'all', 0, 0),
(141, 2, NULL, 3, NULL, 204, 1, 1, 'all', 0, 0),
(140, 2, NULL, 2, NULL, 205, 4, 1, 'all', 0, 0),
(139, 2, NULL, 1, NULL, 206, 32, 1, 'all', 0, 0),
(138, 1, NULL, 3, NULL, 24, 1, 1, 'all', 0, 0),
(137, 1, NULL, 2, NULL, 25, 4, 1, 'all', 0, 0),
(136, 1, NULL, 1, NULL, 26, 32, 1, 'all', 0, 0),
(135, 2, NULL, 3, NULL, 207, 1, 1, 'all', 0, 0),
(134, 2, NULL, 2, NULL, 208, 4, 1, 'all', 0, 0),
(133, 2, NULL, 1, NULL, 209, 32, 1, 'all', 0, 0),
(132, 2, NULL, 3, NULL, 210, 1, 1, 'all', 0, 0),
(131, 2, NULL, 2, NULL, 211, 4, 1, 'all', 0, 0),
(130, 2, NULL, 1, NULL, 212, 32, 1, 'all', 0, 0),
(129, 2, NULL, 3, NULL, 213, 1, 1, 'all', 0, 0),
(128, 2, NULL, 2, NULL, 214, 4, 1, 'all', 0, 0),
(127, 2, NULL, 1, NULL, 215, 32, 1, 'all', 0, 0),
(126, 2, NULL, 3, NULL, 216, 1, 1, 'all', 0, 0),
(125, 2, NULL, 2, NULL, 217, 4, 1, 'all', 0, 0),
(124, 2, NULL, 1, NULL, 218, 32, 1, 'all', 0, 0),
(123, 2, NULL, 3, NULL, 219, 1, 1, 'all', 0, 0),
(122, 2, NULL, 2, NULL, 220, 4, 1, 'all', 0, 0),
(121, 2, NULL, 1, NULL, 221, 32, 1, 'all', 0, 0),
(120, 2, NULL, 3, NULL, 222, 1, 1, 'all', 0, 0),
(119, 2, NULL, 2, NULL, 223, 4, 1, 'all', 0, 0),
(118, 2, NULL, 1, NULL, 224, 32, 1, 'all', 0, 0),
(117, 2, NULL, 3, NULL, 225, 1, 1, 'all', 0, 0),
(116, 2, NULL, 2, NULL, 226, 4, 1, 'all', 0, 0),
(115, 2, NULL, 1, NULL, 227, 32, 1, 'all', 0, 0),
(114, 2, NULL, 3, NULL, 228, 1, 1, 'all', 0, 0),
(113, 2, NULL, 2, NULL, 229, 4, 1, 'all', 0, 0),
(112, 2, NULL, 1, NULL, 230, 32, 1, 'all', 0, 0),
(111, 2, NULL, 3, NULL, 231, 1, 1, 'all', 0, 0),
(110, 2, NULL, 2, NULL, 232, 4, 1, 'all', 0, 0),
(109, 2, NULL, 1, NULL, 233, 32, 1, 'all', 0, 0),
(108, 2, NULL, 3, NULL, 234, 1, 1, 'all', 0, 0),
(107, 2, NULL, 2, NULL, 235, 4, 1, 'all', 0, 0),
(106, 2, NULL, 1, NULL, 236, 32, 1, 'all', 0, 0),
(105, 2, NULL, 3, NULL, 237, 1, 1, 'all', 0, 0),
(104, 2, NULL, 2, NULL, 238, 4, 1, 'all', 0, 0),
(103, 2, NULL, 1, NULL, 239, 32, 1, 'all', 0, 0),
(102, 2, NULL, 3, NULL, 240, 1, 1, 'all', 0, 0),
(101, 2, NULL, 2, NULL, 241, 4, 1, 'all', 0, 0),
(100, 2, NULL, 1, NULL, 242, 32, 1, 'all', 0, 0),
(99, 2, NULL, 3, NULL, 243, 1, 1, 'all', 0, 0),
(98, 2, NULL, 2, NULL, 244, 4, 1, 'all', 0, 0),
(97, 2, NULL, 1, NULL, 245, 32, 1, 'all', 0, 0),
(96, 2, NULL, 3, NULL, 246, 1, 1, 'all', 0, 0),
(95, 2, NULL, 2, NULL, 247, 4, 1, 'all', 0, 0),
(94, 2, NULL, 1, NULL, 248, 32, 1, 'all', 0, 0),
(93, 2, NULL, 3, NULL, 249, 1, 1, 'all', 0, 0),
(92, 2, NULL, 2, NULL, 250, 4, 1, 'all', 0, 0),
(91, 2, NULL, 1, NULL, 251, 32, 1, 'all', 0, 0),
(90, 2, NULL, 3, NULL, 252, 1, 1, 'all', 0, 0),
(89, 2, NULL, 2, NULL, 253, 4, 1, 'all', 0, 0),
(88, 2, NULL, 1, NULL, 254, 32, 1, 'all', 0, 0),
(87, 2, NULL, 3, NULL, 255, 1, 1, 'all', 0, 0),
(86, 2, NULL, 2, NULL, 256, 4, 1, 'all', 0, 0),
(85, 2, NULL, 1, NULL, 257, 32, 1, 'all', 0, 0),
(84, 2, NULL, 3, NULL, 258, 1, 1, 'all', 0, 0),
(83, 2, NULL, 2, NULL, 259, 4, 1, 'all', 0, 0),
(82, 2, NULL, 1, NULL, 260, 32, 1, 'all', 0, 0),
(81, 2, NULL, 3, NULL, 261, 1, 1, 'all', 0, 0),
(80, 2, NULL, 2, NULL, 262, 4, 1, 'all', 0, 0),
(79, 2, NULL, 1, NULL, 263, 32, 1, 'all', 0, 0),
(78, 2, NULL, 3, NULL, 264, 1, 1, 'all', 0, 0),
(77, 2, NULL, 2, NULL, 265, 4, 1, 'all', 0, 0),
(76, 2, NULL, 1, NULL, 266, 32, 1, 'all', 0, 0),
(75, 2, NULL, 3, NULL, 267, 1, 1, 'all', 0, 0),
(74, 2, NULL, 2, NULL, 268, 4, 1, 'all', 0, 0),
(73, 2, NULL, 1, NULL, 269, 32, 1, 'all', 0, 0),
(72, 2, NULL, 3, NULL, 270, 1, 1, 'all', 0, 0),
(71, 2, NULL, 2, NULL, 271, 4, 1, 'all', 0, 0),
(70, 2, NULL, 1, NULL, 272, 32, 1, 'all', 0, 0),
(69, 2, NULL, 3, NULL, 273, 1, 1, 'all', 0, 0),
(68, 2, NULL, 2, NULL, 274, 4, 1, 'all', 0, 0),
(67, 2, NULL, 1, NULL, 275, 32, 1, 'all', 0, 0),
(66, 2, NULL, 3, NULL, 276, 1, 1, 'all', 0, 0),
(65, 2, NULL, 2, NULL, 277, 4, 1, 'all', 0, 0),
(64, 2, NULL, 1, NULL, 278, 32, 1, 'all', 0, 0),
(63, 2, NULL, 3, NULL, 279, 1, 1, 'all', 0, 0),
(62, 2, NULL, 2, NULL, 280, 4, 1, 'all', 0, 0),
(61, 2, NULL, 1, NULL, 281, 32, 1, 'all', 0, 0),
(60, 2, NULL, 3, NULL, 282, 1, 1, 'all', 0, 0),
(59, 2, NULL, 2, NULL, 283, 4, 1, 'all', 0, 0),
(58, 2, NULL, 1, NULL, 284, 32, 1, 'all', 0, 0),
(57, 2, NULL, 3, NULL, 285, 1, 1, 'all', 0, 0),
(56, 2, NULL, 2, NULL, 286, 4, 1, 'all', 0, 0),
(55, 2, NULL, 1, NULL, 287, 32, 1, 'all', 0, 0),
(54, 2, NULL, 3, NULL, 288, 1, 1, 'all', 0, 0),
(53, 2, NULL, 2, NULL, 289, 4, 1, 'all', 0, 0),
(52, 2, NULL, 1, NULL, 290, 32, 1, 'all', 0, 0),
(51, 2, NULL, 3, NULL, 291, 1, 1, 'all', 0, 0),
(50, 2, NULL, 2, NULL, 292, 4, 1, 'all', 0, 0),
(49, 2, NULL, 1, NULL, 293, 32, 1, 'all', 0, 0),
(48, 2, NULL, 3, NULL, 294, 1, 1, 'all', 0, 0),
(47, 2, NULL, 2, NULL, 295, 4, 1, 'all', 0, 0),
(46, 2, NULL, 1, NULL, 296, 32, 1, 'all', 0, 0),
(45, 2, NULL, 3, NULL, 297, 1, 1, 'all', 0, 0),
(44, 2, NULL, 2, NULL, 298, 4, 1, 'all', 0, 0),
(43, 2, NULL, 1, NULL, 299, 32, 1, 'all', 0, 0),
(42, 2, NULL, 3, NULL, 300, 1, 1, 'all', 0, 0),
(41, 2, NULL, 2, NULL, 301, 4, 1, 'all', 0, 0),
(40, 2, NULL, 1, NULL, 302, 32, 1, 'all', 0, 0),
(39, 2, NULL, 3, NULL, 303, 1, 1, 'all', 0, 0),
(38, 2, NULL, 2, NULL, 304, 4, 1, 'all', 0, 0),
(37, 2, NULL, 1, NULL, 305, 32, 1, 'all', 0, 0),
(36, 2, NULL, 3, NULL, 306, 1, 1, 'all', 0, 0),
(35, 2, NULL, 2, NULL, 307, 4, 1, 'all', 0, 0),
(34, 2, NULL, 1, NULL, 308, 32, 1, 'all', 0, 0),
(33, 2, NULL, 3, NULL, 309, 1, 1, 'all', 0, 0),
(32, 2, NULL, 2, NULL, 310, 4, 1, 'all', 0, 0),
(31, 2, NULL, 1, NULL, 311, 32, 1, 'all', 0, 0),
(30, 2, NULL, 3, NULL, 312, 1, 1, 'all', 0, 0),
(29, 2, NULL, 2, NULL, 313, 4, 1, 'all', 0, 0),
(28, 2, NULL, 1, NULL, 314, 32, 1, 'all', 0, 0),
(27, 2, NULL, 3, NULL, 315, 1, 1, 'all', 0, 0),
(26, 2, NULL, 2, NULL, 316, 4, 1, 'all', 0, 0),
(25, 2, NULL, 1, NULL, 317, 32, 1, 'all', 0, 0),
(24, 2, NULL, 3, NULL, 318, 1, 1, 'all', 0, 0),
(23, 2, NULL, 2, NULL, 319, 4, 1, 'all', 0, 0),
(22, 2, NULL, 1, NULL, 320, 32, 1, 'all', 0, 0),
(21, 2, NULL, 3, NULL, 321, 1, 1, 'all', 0, 0),
(20, 2, NULL, 2, NULL, 322, 4, 1, 'all', 0, 0),
(19, 2, NULL, 1, NULL, 323, 32, 1, 'all', 0, 0),
(18, 2, NULL, 3, NULL, 324, 1, 1, 'all', 0, 0),
(17, 2, NULL, 2, NULL, 325, 4, 1, 'all', 0, 0),
(16, 2, NULL, 1, NULL, 326, 32, 1, 'all', 0, 0),
(15, 2, NULL, 3, NULL, 327, 1, 1, 'all', 0, 0),
(14, 2, NULL, 2, NULL, 328, 4, 1, 'all', 0, 0),
(13, 2, NULL, 1, NULL, 329, 32, 1, 'all', 0, 0),
(12, 2, NULL, 3, NULL, 330, 1, 1, 'all', 0, 0),
(11, 2, NULL, 2, NULL, 331, 4, 1, 'all', 0, 0),
(10, 2, NULL, 1, NULL, 332, 32, 1, 'all', 0, 0),
(9, 2, NULL, 3, NULL, 333, 1, 1, 'all', 0, 0),
(8, 2, NULL, 2, NULL, 334, 4, 1, 'all', 0, 0),
(7, 2, NULL, 1, NULL, 335, 32, 1, 'all', 0, 0),
(6, 2, NULL, 3, NULL, 336, 1, 1, 'all', 0, 0),
(5, 2, NULL, 2, NULL, 337, 4, 1, 'all', 0, 0),
(4, 2, NULL, 1, NULL, 338, 32, 1, 'all', 0, 0),
(3, 1, NULL, 3, NULL, 27, 1, 1, 'all', 0, 0),
(2, 1, NULL, 2, NULL, 28, 4, 1, 'all', 0, 0),
(1, 1, NULL, 1, NULL, 29, 32, 1, 'all', 0, 0);
            ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE FROM acl_entries");
        $this->addSql("DELETE FROM acl_security_identities");
        $this->addSql("DELETE FROM acl_classes");

    }
}