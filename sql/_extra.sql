
--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `accounts_free_buff_shield`
--
ALTER TABLE `accounts_free_buff_shield`
  ADD PRIMARY KEY (`account_name`);

--
-- Indexes for table `accounts_pcmaster_golden`
--
ALTER TABLE `accounts_pcmaster_golden`
  ADD PRIMARY KEY (`account_name`,`index_id`);

--
-- Indexes for table `accounts_shop_limit`
--
ALTER TABLE `accounts_shop_limit`
  ADD PRIMARY KEY (`accountName`,`buyShopId`,`buyItemId`);

--
-- Indexes for table `admin_activity`
--
ALTER TABLE `admin_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ai_user`
--
ALTER TABLE `ai_user`
  ADD PRIMARY KEY (`name`,`ai_type`);

--
-- Indexes for table `ai_user_buff`
--
ALTER TABLE `ai_user_buff`
  ADD PRIMARY KEY (`class`,`elfAttr`);

--
-- Indexes for table `ai_user_drop`
--
ALTER TABLE `ai_user_drop`
  ADD PRIMARY KEY (`class`,`itemId`);

--
-- Indexes for table `ai_user_fish`
--
ALTER TABLE `ai_user_fish`
  ADD PRIMARY KEY (`loc_x`,`loc_y`);

--
-- Indexes for table `ai_user_item`
--
ALTER TABLE `ai_user_item`
  ADD PRIMARY KEY (`class`,`itemId`);

--
-- Indexes for table `ai_user_ment`
--
ALTER TABLE `ai_user_ment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ai_user_skill`
--
ALTER TABLE `ai_user_skill`
  ADD PRIMARY KEY (`class`);

--
-- Indexes for table `app_alim_log`
--
ALTER TABLE `app_alim_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`account_name`);

--
-- Indexes for table `app_auth_extension`
--
ALTER TABLE `app_auth_extension`
  ADD PRIMARY KEY (`extension`);

--
-- Indexes for table `app_board_content`
--
ALTER TABLE `app_board_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_board_content_comment`
--
ALTER TABLE `app_board_content_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_board_free`
--
ALTER TABLE `app_board_free`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_board_free_comment`
--
ALTER TABLE `app_board_free_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_board_notice`
--
ALTER TABLE `app_board_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_board_pitch`
--
ALTER TABLE `app_board_pitch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_board_pitch_comment`
--
ALTER TABLE `app_board_pitch_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_coupon`
--
ALTER TABLE `app_coupon`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `app_customer`
--
ALTER TABLE `app_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_customer_normal`
--
ALTER TABLE `app_customer_normal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_dictionary_item`
--
ALTER TABLE `app_dictionary_item`
  ADD PRIMARY KEY (`schar`);

--
-- Indexes for table `app_engine_log`
--
ALTER TABLE `app_engine_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_extra_info`
--
ALTER TABLE `app_extra_info`
  ADD PRIMARY KEY (`extra_info_id`),
  ADD UNIQUE KEY `idx_extra_info_name` (`name`);

--
-- Indexes for table `app_guide`
--
ALTER TABLE `app_guide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_guide_boss`
--
ALTER TABLE `app_guide_boss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_guide_recommend`
--
ALTER TABLE `app_guide_recommend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_item_search`
--
ALTER TABLE `app_item_search`
  ADD PRIMARY KEY (`seq`,`item_name`);

--
-- Indexes for table `app_nshop`
--
ALTER TABLE `app_nshop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_page_info`
--
ALTER TABLE `app_page_info`
  ADD PRIMARY KEY (`uri`);

--
-- Indexes for table `app_powerbook`
--
ALTER TABLE `app_powerbook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_powerbook_guide`
--
ALTER TABLE `app_powerbook_guide`
  ADD PRIMARY KEY (`group_type`,`id`);

--
-- Indexes for table `app_promotion`
--
ALTER TABLE `app_promotion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_report`
--
ALTER TABLE `app_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_shop_rank`
--
ALTER TABLE `app_shop_rank`
  ADD PRIMARY KEY (`group_type`,`shop_type`,`id`);

--
-- Indexes for table `app_support`
--
ALTER TABLE `app_support`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_support_message`
--
ALTER TABLE `app_support_message`
  ADD PRIMARY KEY (`type`,`index_id`);

--
-- Indexes for table `app_support_request`
--
ALTER TABLE `app_support_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_trade`
--
ALTER TABLE `app_trade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_uri_block`
--
ALTER TABLE `app_uri_block`
  ADD PRIMARY KEY (`uri`);

--
-- Indexes for table `app_uri_pass`
--
ALTER TABLE `app_uri_pass`
  ADD PRIMARY KEY (`uri`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`areaid`);

--
-- Indexes for table `armor`
--
ALTER TABLE `armor`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `armor_set`
--
ALTER TABLE `armor_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_accounts`
--
ALTER TABLE `attendance_accounts`
  ADD PRIMARY KEY (`account`);

--
-- Indexes for table `attendance_item`
--
ALTER TABLE `attendance_item`
  ADD PRIMARY KEY (`groupType`,`index`);

--
-- Indexes for table `attendance_item_random`
--
ALTER TABLE `attendance_item_random`
  ADD PRIMARY KEY (`groupType`,`index`);

--
-- Indexes for table `auth_ip`
--
ALTER TABLE `auth_ip`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `autoloot`
--
ALTER TABLE `autoloot`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`attackerType`,`targetType`);

--
-- Indexes for table `ban_account`
--
ALTER TABLE `ban_account`
  ADD PRIMARY KEY (`account`,`reason`);

--
-- Indexes for table `ban_board`
--
ALTER TABLE `ban_board`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `ban_hdd`
--
ALTER TABLE `ban_hdd`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `ban_ip`
--
ALTER TABLE `ban_ip`
  ADD PRIMARY KEY (`address`);

--
-- Indexes for table `beginner`
--
ALTER TABLE `beginner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beginner_addteleport`
--
ALTER TABLE `beginner_addteleport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`char_id`);

--
-- Indexes for table `beginner_quest`
--
ALTER TABLE `beginner_quest`
  ADD PRIMARY KEY (`quest_id`);

--
-- Indexes for table `beginner_quest_drop`
--
ALTER TABLE `beginner_quest_drop`
  ADD PRIMARY KEY (`classId`);

--
-- Indexes for table `bin_armor_element_common`
--
ALTER TABLE `bin_armor_element_common`
  ADD PRIMARY KEY (`type`,`enchant`);

--
-- Indexes for table `bin_catalyst_common`
--
ALTER TABLE `bin_catalyst_common`
  ADD PRIMARY KEY (`nameId`,`input`,`output`,`failOutput`);

--
-- Indexes for table `bin_charged_time_map_common`
--
ALTER TABLE `bin_charged_time_map_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin_companion_class_common`
--
ALTER TABLE `bin_companion_class_common`
  ADD PRIMARY KEY (`classId`);

--
-- Indexes for table `bin_companion_enchant_common`
--
ALTER TABLE `bin_companion_enchant_common`
  ADD PRIMARY KEY (`tier`);

--
-- Indexes for table `bin_companion_skill_common`
--
ALTER TABLE `bin_companion_skill_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin_companion_stat_common`
--
ALTER TABLE `bin_companion_stat_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin_craft_common`
--
ALTER TABLE `bin_craft_common`
  ADD PRIMARY KEY (`craft_id`);

--
-- Indexes for table `bin_einpoint_cost_common`
--
ALTER TABLE `bin_einpoint_cost_common`
  ADD PRIMARY KEY (`value`);

--
-- Indexes for table `bin_einpoint_faith_common`
--
ALTER TABLE `bin_einpoint_faith_common`
  ADD PRIMARY KEY (`GroupId`,`Index_indexId`);

--
-- Indexes for table `bin_einpoint_meta_common`
--
ALTER TABLE `bin_einpoint_meta_common`
  ADD PRIMARY KEY (`index_id`);

--
-- Indexes for table `bin_einpoint_normal_prob_common`
--
ALTER TABLE `bin_einpoint_normal_prob_common`
  ADD PRIMARY KEY (`Normal_level`);

--
-- Indexes for table `bin_einpoint_overstat_prob_common`
--
ALTER TABLE `bin_einpoint_overstat_prob_common`
  ADD PRIMARY KEY (`over_level`);

--
-- Indexes for table `bin_einpoint_prob_table_common`
--
ALTER TABLE `bin_einpoint_prob_table_common`
  ADD PRIMARY KEY (`isLastChance`,`bonusPoint`);

--
-- Indexes for table `bin_einpoint_stat_common`
--
ALTER TABLE `bin_einpoint_stat_common`
  ADD PRIMARY KEY (`index_id`,`value`);

--
-- Indexes for table `bin_element_enchant_common`
--
ALTER TABLE `bin_element_enchant_common`
  ADD PRIMARY KEY (`prob_index`,`type_index`,`level`);

--
-- Indexes for table `bin_enchant_scroll_table_common`
--
ALTER TABLE `bin_enchant_scroll_table_common`
  ADD PRIMARY KEY (`enchantType`,`nameid`);

--
-- Indexes for table `bin_enchant_table_common`
--
ALTER TABLE `bin_enchant_table_common`
  ADD PRIMARY KEY (`item_index`,`bonusLevel_index`);

--
-- Indexes for table `bin_entermaps_common`
--
ALTER TABLE `bin_entermaps_common`
  ADD PRIMARY KEY (`id`,`action_name`);

--
-- Indexes for table `bin_favorbook_common`
--
ALTER TABLE `bin_favorbook_common`
  ADD PRIMARY KEY (`category_id`,`slot_id`);

--
-- Indexes for table `bin_general_goods_common`
--
ALTER TABLE `bin_general_goods_common`
  ADD PRIMARY KEY (`NameId`);

--
-- Indexes for table `bin_huntingquest_common`
--
ALTER TABLE `bin_huntingquest_common`
  ADD PRIMARY KEY (`requiredCondition_Map`,`requiredCondition_LocationDesc`);

--
-- Indexes for table `bin_indun_common`
--
ALTER TABLE `bin_indun_common`
  ADD PRIMARY KEY (`mapKind`);

--
-- Indexes for table `bin_item_common`
--
ALTER TABLE `bin_item_common`
  ADD PRIMARY KEY (`name_id`);

--
-- Indexes for table `bin_ndl_common`
--
ALTER TABLE `bin_ndl_common`
  ADD PRIMARY KEY (`map_number`,`npc_classId`,`territory_startXY`,`territory_endXY`);

--
-- Indexes for table `bin_npc_common`
--
ALTER TABLE `bin_npc_common`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `bin_passivespell_common`
--
ALTER TABLE `bin_passivespell_common`
  ADD PRIMARY KEY (`passive_id`);

--
-- Indexes for table `bin_portrait_common`
--
ALTER TABLE `bin_portrait_common`
  ADD PRIMARY KEY (`asset_id`);

--
-- Indexes for table `bin_potential_common`
--
ALTER TABLE `bin_potential_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin_ship_common`
--
ALTER TABLE `bin_ship_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bin_spell_common`
--
ALTER TABLE `bin_spell_common`
  ADD PRIMARY KEY (`spell_id`);

--
-- Indexes for table `bin_timecollection_common`
--
ALTER TABLE `bin_timecollection_common`
  ADD PRIMARY KEY (`group_id`,`group_set_id`);

--
-- Indexes for table `bin_treasureboxreward_common`
--
ALTER TABLE `bin_treasureboxreward_common`
  ADD PRIMARY KEY (`nameid`);

--
-- Indexes for table `bin_treasurebox_common`
--
ALTER TABLE `bin_treasurebox_common`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_app_lfc`
--
ALTER TABLE `board_app_lfc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_auction`
--
ALTER TABLE `board_auction`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `board_free`
--
ALTER TABLE `board_free`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_notice`
--
ALTER TABLE `board_notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_notice1`
--
ALTER TABLE `board_notice1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_notice2`
--
ALTER TABLE `board_notice2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_notice3`
--
ALTER TABLE `board_notice3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_posts_fix`
--
ALTER TABLE `board_posts_fix`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_posts_key`
--
ALTER TABLE `board_posts_key`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_user`
--
ALTER TABLE `board_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bots`
--
ALTER TABLE `bots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `castle`
--
ALTER TABLE `castle`
  ADD PRIMARY KEY (`castle_id`);

--
-- Indexes for table `castle_present`
--
ALTER TABLE `castle_present`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `castle_soldier`
--
ALTER TABLE `castle_soldier`
  ADD PRIMARY KEY (`castle_id`);

--
-- Indexes for table `catalyst`
--
ALTER TABLE `catalyst`
  ADD PRIMARY KEY (`nameId`,`input`);

--
-- Indexes for table `catalyst_custom`
--
ALTER TABLE `catalyst_custom`
  ADD PRIMARY KEY (`itemId`,`input_itemId`,`input_enchant`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`objid`),
  ADD KEY `key_id` (`account_name`,`char_name`);

--
-- Indexes for table `character_arca`
--
ALTER TABLE `character_arca`
  ADD PRIMARY KEY (`id`,`charId`);

--
-- Indexes for table `character_beginner_quest`
--
ALTER TABLE `character_beginner_quest`
  ADD PRIMARY KEY (`charId`);

--
-- Indexes for table `character_buddys`
--
ALTER TABLE `character_buddys`
  ADD PRIMARY KEY (`char_id`,`buddy_name`),
  ADD KEY `key_id` (`id`);

--
-- Indexes for table `character_buff`
--
ALTER TABLE `character_buff`
  ADD PRIMARY KEY (`char_obj_id`,`skill_id`);

--
-- Indexes for table `character_companion`
--
ALTER TABLE `character_companion`
  ADD PRIMARY KEY (`item_objId`);

--
-- Indexes for table `character_companion_buff`
--
ALTER TABLE `character_companion_buff`
  ADD PRIMARY KEY (`objid`,`buff_id`);

--
-- Indexes for table `character_config`
--
ALTER TABLE `character_config`
  ADD PRIMARY KEY (`object_id`);

--
-- Indexes for table `character_death_exp`
--
ALTER TABLE `character_death_exp`
  ADD PRIMARY KEY (`char_id`,`delete_time`);

--
-- Indexes for table `character_death_item`
--
ALTER TABLE `character_death_item`
  ADD PRIMARY KEY (`db_id`);

--
-- Indexes for table `character_einhasadfaith`
--
ALTER TABLE `character_einhasadfaith`
  ADD PRIMARY KEY (`objId`,`indexId`);

--
-- Indexes for table `character_einhasadstat`
--
ALTER TABLE `character_einhasadstat`
  ADD PRIMARY KEY (`objid`);

--
-- Indexes for table `character_elf_warehouse`
--
ALTER TABLE `character_elf_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`account_name`);

--
-- Indexes for table `character_equipset`
--
ALTER TABLE `character_equipset`
  ADD PRIMARY KEY (`charId`);

--
-- Indexes for table `character_eventpush`
--
ALTER TABLE `character_eventpush`
  ADD PRIMARY KEY (`push_id`);

--
-- Indexes for table `character_exclude`
--
ALTER TABLE `character_exclude`
  ADD PRIMARY KEY (`char_id`,`type`,`exclude_id`),
  ADD KEY `key_id` (`id`);

--
-- Indexes for table `character_fairly_config`
--
ALTER TABLE `character_fairly_config`
  ADD PRIMARY KEY (`object_id`);

--
-- Indexes for table `character_favorbook`
--
ALTER TABLE `character_favorbook`
  ADD PRIMARY KEY (`charObjId`,`category`,`slotId`);

--
-- Indexes for table `character_hunting_quest`
--
ALTER TABLE `character_hunting_quest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `character_items`
--
ALTER TABLE `character_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`char_id`);

--
-- Indexes for table `character_monsterbooklist`
--
ALTER TABLE `character_monsterbooklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `character_package_warehouse`
--
ALTER TABLE `character_package_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`account_name`);

--
-- Indexes for table `character_present_warehouse`
--
ALTER TABLE `character_present_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`account_name`);

--
-- Indexes for table `character_quests`
--
ALTER TABLE `character_quests`
  ADD PRIMARY KEY (`char_id`,`quest_id`);

--
-- Indexes for table `character_revenge`
--
ALTER TABLE `character_revenge`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `character_shop_limit`
--
ALTER TABLE `character_shop_limit`
  ADD PRIMARY KEY (`characterId`,`buyShopId`,`buyItemId`);

--
-- Indexes for table `character_skills_active`
--
ALTER TABLE `character_skills_active`
  ADD PRIMARY KEY (`char_obj_id`,`skill_id`);

--
-- Indexes for table `character_skills_passive`
--
ALTER TABLE `character_skills_passive`
  ADD PRIMARY KEY (`char_obj_id`,`passive_id`);

--
-- Indexes for table `character_soldier`
--
ALTER TABLE `character_soldier`
  ADD PRIMARY KEY (`char_id`,`time`);

--
-- Indexes for table `character_special_warehouse`
--
ALTER TABLE `character_special_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`account_name`);

--
-- Indexes for table `character_teleport`
--
ALTER TABLE `character_teleport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`char_id`);

--
-- Indexes for table `character_timecollection`
--
ALTER TABLE `character_timecollection`
  ADD PRIMARY KEY (`charObjId`,`groupId`,`setId`);

--
-- Indexes for table `character_warehouse`
--
ALTER TABLE `character_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`account_name`);

--
-- Indexes for table `clan_bless_buff`
--
ALTER TABLE `clan_bless_buff`
  ADD PRIMARY KEY (`number`,`buff_id`);

--
-- Indexes for table `clan_contribution_buff`
--
ALTER TABLE `clan_contribution_buff`
  ADD PRIMARY KEY (`clan_id`);

--
-- Indexes for table `clan_data`
--
ALTER TABLE `clan_data`
  ADD PRIMARY KEY (`clan_id`);

--
-- Indexes for table `clan_emblem_attention`
--
ALTER TABLE `clan_emblem_attention`
  ADD PRIMARY KEY (`clanname`,`attentionClanname`);

--
-- Indexes for table `clan_history`
--
ALTER TABLE `clan_history`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `clan_joinning`
--
ALTER TABLE `clan_joinning`
  ADD PRIMARY KEY (`pledge_uid`,`user_uid`);

--
-- Indexes for table `clan_matching_list`
--
ALTER TABLE `clan_matching_list`
  ADD PRIMARY KEY (`clanname`);

--
-- Indexes for table `clan_warehouse`
--
ALTER TABLE `clan_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`clan_name`);

--
-- Indexes for table `clan_warehouse_list`
--
ALTER TABLE `clan_warehouse_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clan_warehouse_log`
--
ALTER TABLE `clan_warehouse_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `connect_reward`
--
ALTER TABLE `connect_reward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `craft_block`
--
ALTER TABLE `craft_block`
  ADD PRIMARY KEY (`craft_id`);

--
-- Indexes for table `craft_info`
--
ALTER TABLE `craft_info`
  ADD PRIMARY KEY (`craft_id`);

--
-- Indexes for table `craft_npcs`
--
ALTER TABLE `craft_npcs`
  ADD PRIMARY KEY (`npc_id`);

--
-- Indexes for table `craft_success_count_user`
--
ALTER TABLE `craft_success_count_user`
  ADD PRIMARY KEY (`accountName`,`charId`,`craftId`);

--
-- Indexes for table `dogfight_tickets`
--
ALTER TABLE `dogfight_tickets`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `droplist`
--
ALTER TABLE `droplist`
  ADD PRIMARY KEY (`mobId`,`itemId`);

--
-- Indexes for table `droptype_npc`
--
ALTER TABLE `droptype_npc`
  ADD PRIMARY KEY (`mobId`);

--
-- Indexes for table `dungeon`
--
ALTER TABLE `dungeon`
  ADD PRIMARY KEY (`src_x`,`src_y`,`src_mapid`);

--
-- Indexes for table `dungeon_random`
--
ALTER TABLE `dungeon_random`
  ADD PRIMARY KEY (`src_x`,`src_y`,`src_mapid`);

--
-- Indexes for table `dungeon_timer`
--
ALTER TABLE `dungeon_timer`
  ADD PRIMARY KEY (`timerId`);

--
-- Indexes for table `dungeon_timer_account`
--
ALTER TABLE `dungeon_timer_account`
  ADD PRIMARY KEY (`account`,`timerId`);

--
-- Indexes for table `dungeon_timer_character`
--
ALTER TABLE `dungeon_timer_character`
  ADD PRIMARY KEY (`charId`,`timerId`);

--
-- Indexes for table `dungeon_timer_item`
--
ALTER TABLE `dungeon_timer_item`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `enchant_result`
--
ALTER TABLE `enchant_result`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `etcitem`
--
ALTER TABLE `etcitem`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `exp`
--
ALTER TABLE `exp`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `favorbook`
--
ALTER TABLE `favorbook`
  ADD PRIMARY KEY (`category`,`slotId`);

--
-- Indexes for table `free_pvp_region`
--
ALTER TABLE `free_pvp_region`
  ADD PRIMARY KEY (`worldNumber`,`box_index`);

--
-- Indexes for table `getback`
--
ALTER TABLE `getback`
  ADD PRIMARY KEY (`area_x1`,`area_y1`,`area_x2`,`area_y2`,`area_mapid`);

--
-- Indexes for table `getback_restart`
--
ALTER TABLE `getback_restart`
  ADD PRIMARY KEY (`area`);

--
-- Indexes for table `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `hunting_quest`
--
ALTER TABLE `hunting_quest`
  ADD PRIMARY KEY (`quest_id`);

--
-- Indexes for table `hunting_quest_teleport`
--
ALTER TABLE `hunting_quest_teleport`
  ADD PRIMARY KEY (`action_string`);

--
-- Indexes for table `inter_race_region`
--
ALTER TABLE `inter_race_region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_bookmark`
--
ALTER TABLE `item_bookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`id`);

--
-- Indexes for table `item_box`
--
ALTER TABLE `item_box`
  ADD PRIMARY KEY (`boxId`,`classType`,`itemId`);

--
-- Indexes for table `item_buff`
--
ALTER TABLE `item_buff`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_click_message`
--
ALTER TABLE `item_click_message`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `item_collection`
--
ALTER TABLE `item_collection`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `item_enchant_ablity`
--
ALTER TABLE `item_enchant_ablity`
  ADD PRIMARY KEY (`itemId`,`enchant`);

--
-- Indexes for table `item_key_boss`
--
ALTER TABLE `item_key_boss`
  ADD PRIMARY KEY (`item_obj_id`,`key_id`);

--
-- Indexes for table `item_ment`
--
ALTER TABLE `item_ment`
  ADD PRIMARY KEY (`itemId`,`mentType`);

--
-- Indexes for table `item_selector`
--
ALTER TABLE `item_selector`
  ADD PRIMARY KEY (`itemId`,`selectItemId`);

--
-- Indexes for table `item_selector_warehouse`
--
ALTER TABLE `item_selector_warehouse`
  ADD PRIMARY KEY (`itemId`,`selectItemId`);

--
-- Indexes for table `item_terms`
--
ALTER TABLE `item_terms`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `letter`
--
ALTER TABLE `letter`
  ADD PRIMARY KEY (`item_object_id`);

--
-- Indexes for table `letter_command`
--
ALTER TABLE `letter_command`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letter_spam`
--
ALTER TABLE `letter_spam`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `levelup_quests_item`
--
ALTER TABLE `levelup_quests_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `bid` (`level`);

--
-- Indexes for table `log_chat`
--
ALTER TABLE `log_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_cwarehouse`
--
ALTER TABLE `log_cwarehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_enchant`
--
ALTER TABLE `log_enchant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id` (`char_id`);

--
-- Indexes for table `log_private_shop`
--
ALTER TABLE `log_private_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_shop`
--
ALTER TABLE `log_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_warehouse`
--
ALTER TABLE `log_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magicdoll_info`
--
ALTER TABLE `magicdoll_info`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `magicdoll_potential`
--
ALTER TABLE `magicdoll_potential`
  ADD PRIMARY KEY (`bonusId`);

--
-- Indexes for table `mapids`
--
ALTER TABLE `mapids`
  ADD PRIMARY KEY (`mapid`);

--
-- Indexes for table `map_balance`
--
ALTER TABLE `map_balance`
  ADD PRIMARY KEY (`mapId`);

--
-- Indexes for table `map_fix_key`
--
ALTER TABLE `map_fix_key`
  ADD PRIMARY KEY (`locX`,`locY`,`mapId`);

--
-- Indexes for table `map_type`
--
ALTER TABLE `map_type`
  ADD PRIMARY KEY (`mapId`);

--
-- Indexes for table `marble`
--
ALTER TABLE `marble`
  ADD PRIMARY KEY (`marble_id`);

--
-- Indexes for table `mobgroup`
--
ALTER TABLE `mobgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobskill`
--
ALTER TABLE `mobskill`
  ADD PRIMARY KEY (`mobid`,`actNo`);

--
-- Indexes for table `monster_book`
--
ALTER TABLE `monster_book`
  ADD PRIMARY KEY (`monsternumber`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notification_event_npc`
--
ALTER TABLE `notification_event_npc`
  ADD PRIMARY KEY (`notification_id`,`order_id`);

--
-- Indexes for table `npc`
--
ALTER TABLE `npc`
  ADD PRIMARY KEY (`npcid`);

--
-- Indexes for table `npcaction`
--
ALTER TABLE `npcaction`
  ADD PRIMARY KEY (`npcid`);

--
-- Indexes for table `npcaction_teleport`
--
ALTER TABLE `npcaction_teleport`
  ADD PRIMARY KEY (`npcId`,`actionName`);

--
-- Indexes for table `npcchat`
--
ALTER TABLE `npcchat`
  ADD PRIMARY KEY (`npc_id`,`chat_timing`);

--
-- Indexes for table `npc_info`
--
ALTER TABLE `npc_info`
  ADD PRIMARY KEY (`npcId`);

--
-- Indexes for table `npc_night`
--
ALTER TABLE `npc_night`
  ADD PRIMARY KEY (`npcId`,`targetMapId`);

--
-- Indexes for table `penalty_pass_item`
--
ALTER TABLE `penalty_pass_item`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `penalty_protect_item`
--
ALTER TABLE `penalty_protect_item`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `playsupport`
--
ALTER TABLE `playsupport`
  ADD PRIMARY KEY (`mapid`);

--
-- Indexes for table `polyitems`
--
ALTER TABLE `polyitems`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `polymorphs`
--
ALTER TABLE `polymorphs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polyweapon`
--
ALTER TABLE `polyweapon`
  ADD PRIMARY KEY (`polyId`);

--
-- Indexes for table `probability_by_spell`
--
ALTER TABLE `probability_by_spell`
  ADD PRIMARY KEY (`skill_id`,`skill_type`);

--
-- Indexes for table `proto_packet`
--
ALTER TABLE `proto_packet`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `race_div_record`
--
ALTER TABLE `race_div_record`
  ADD PRIMARY KEY (`id`,`bug_number`);

--
-- Indexes for table `race_record`
--
ALTER TABLE `race_record`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `race_tickets`
--
ALTER TABLE `race_tickets`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `repair_item_cost`
--
ALTER TABLE `repair_item_cost`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`target`,`reporter`);

--
-- Indexes for table `resolvent`
--
ALTER TABLE `resolvent`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `robot_location`
--
ALTER TABLE `robot_location`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `robot_message`
--
ALTER TABLE `robot_message`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `robot_name`
--
ALTER TABLE `robot_name`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `robot_teleport_list`
--
ALTER TABLE `robot_teleport_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `serverinfo`
--
ALTER TABLE `serverinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `server_explain`
--
ALTER TABLE `server_explain`
  ADD PRIMARY KEY (`num`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`npc_id`,`item_id`,`order_id`);

--
-- Indexes for table `shop_aden`
--
ALTER TABLE `shop_aden`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_info`
--
ALTER TABLE `shop_info`
  ADD PRIMARY KEY (`npcId`);

--
-- Indexes for table `shop_limit`
--
ALTER TABLE `shop_limit`
  ADD PRIMARY KEY (`shopId`,`itemId`);

--
-- Indexes for table `shop_npc`
--
ALTER TABLE `shop_npc`
  ADD PRIMARY KEY (`npc_id`,`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `skills_handler`
--
ALTER TABLE `skills_handler`
  ADD PRIMARY KEY (`skillId`);

--
-- Indexes for table `skills_info`
--
ALTER TABLE `skills_info`
  ADD PRIMARY KEY (`skillId`);

--
-- Indexes for table `skills_passive`
--
ALTER TABLE `skills_passive`
  ADD PRIMARY KEY (`passive_id`);

--
-- Indexes for table `spawnlist`
--
ALTER TABLE `spawnlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_arrow`
--
ALTER TABLE `spawnlist_arrow`
  ADD PRIMARY KEY (`npc_id`,`locx`,`locy`,`mapid`);

--
-- Indexes for table `spawnlist_boss`
--
ALTER TABLE `spawnlist_boss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_boss_sign`
--
ALTER TABLE `spawnlist_boss_sign`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_clandungeon`
--
ALTER TABLE `spawnlist_clandungeon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_door`
--
ALTER TABLE `spawnlist_door`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_furniture`
--
ALTER TABLE `spawnlist_furniture`
  ADD PRIMARY KEY (`item_obj_id`);

--
-- Indexes for table `spawnlist_indun`
--
ALTER TABLE `spawnlist_indun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_light`
--
ALTER TABLE `spawnlist_light`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_npc`
--
ALTER TABLE `spawnlist_npc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_npc_cash_shop`
--
ALTER TABLE `spawnlist_npc_cash_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_npc_shop`
--
ALTER TABLE `spawnlist_npc_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_other`
--
ALTER TABLE `spawnlist_other`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_ruun`
--
ALTER TABLE `spawnlist_ruun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_trap`
--
ALTER TABLE `spawnlist_trap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_ub`
--
ALTER TABLE `spawnlist_ub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_unicorntemple`
--
ALTER TABLE `spawnlist_unicorntemple`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spawnlist_worldwar`
--
ALTER TABLE `spawnlist_worldwar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spell_melt`
--
ALTER TABLE `spell_melt`
  ADD PRIMARY KEY (`skillId`,`passiveId`);

--
-- Indexes for table `spr_action`
--
ALTER TABLE `spr_action`
  ADD PRIMARY KEY (`spr_id`,`act_id`);

--
-- Indexes for table `spr_info`
--
ALTER TABLE `spr_info`
  ADD PRIMARY KEY (`spr_id`);

--
-- Indexes for table `tb_bookquest_compensate`
--
ALTER TABLE `tb_bookquest_compensate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_lfccompensate`
--
ALTER TABLE `tb_lfccompensate`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_lfctypes`
--
ALTER TABLE `tb_lfctypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_monster_book`
--
ALTER TABLE `tb_monster_book`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tb_monster_book_clearinfo`
--
ALTER TABLE `tb_monster_book_clearinfo`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `tb_user_monster_book`
--
ALTER TABLE `tb_user_monster_book`
  ADD PRIMARY KEY (`char_id`,`book_id`);

--
-- Indexes for table `tb_user_week_quest`
--
ALTER TABLE `tb_user_week_quest`
  ADD PRIMARY KEY (`char_id`,`difficulty`,`section`);

--
-- Indexes for table `tb_weekquest_compensate`
--
ALTER TABLE `tb_weekquest_compensate`
  ADD PRIMARY KEY (`button_no`);

--
-- Indexes for table `tb_weekquest_matrix`
--
ALTER TABLE `tb_weekquest_matrix`
  ADD PRIMARY KEY (`difficulty`);

--
-- Indexes for table `tb_weekquest_updateinfo`
--
ALTER TABLE `tb_weekquest_updateinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_coupon`
--
ALTER TABLE `tj_coupon`
  ADD PRIMARY KEY (`objId`);

--
-- Indexes for table `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`town_id`);

--
-- Indexes for table `town_npc`
--
ALTER TABLE `town_npc`
  ADD PRIMARY KEY (`npc_id`);

--
-- Indexes for table `trap`
--
ALTER TABLE `trap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ub_rank`
--
ALTER TABLE `ub_rank`
  ADD PRIMARY KEY (`ub_id`,`char_name`);

--
-- Indexes for table `ub_settings`
--
ALTER TABLE `ub_settings`
  ADD PRIMARY KEY (`ub_id`);

--
-- Indexes for table `uml_conversion`
--
ALTER TABLE `uml_conversion`
  ADD PRIMARY KEY (`oldname`) USING BTREE;

--
-- Indexes for table `util_fighter`
--
ALTER TABLE `util_fighter`
  ADD PRIMARY KEY (`Num`);

--
-- Indexes for table `util_racer`
--
ALTER TABLE `util_racer`
  ADD PRIMARY KEY (`Num`);

--
-- Indexes for table `war_time`
--
ALTER TABLE `war_time`
  ADD PRIMARY KEY (`castleId`,`day`);

--
-- Indexes for table `weapon`
--
ALTER TABLE `weapon`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `weapon_damege`
--
ALTER TABLE `weapon_damege`
  ADD PRIMARY KEY (`item_id`,`name`);

--
-- Indexes for table `weapon_skill`
--
ALTER TABLE `weapon_skill`
  ADD PRIMARY KEY (`weapon_id`,`attackType`);

--
-- Indexes for table `weapon_skill_model`
--
ALTER TABLE `weapon_skill_model`
  ADD PRIMARY KEY (`item_id`) USING BTREE;

--
-- Indexes for table `weapon_skill_spell_def`
--
ALTER TABLE `weapon_skill_spell_def`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_activity`
--
ALTER TABLE `admin_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_alim_log`
--
ALTER TABLE `app_alim_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_extra_info`
--
ALTER TABLE `app_extra_info`
  MODIFY `extra_info_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_item_search`
--
ALTER TABLE `app_item_search`
  MODIFY `seq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_nshop`
--
ALTER TABLE `app_nshop`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `armor_set`
--
ALTER TABLE `armor_set`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beginner`
--
ALTER TABLE `beginner`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bots`
--
ALTER TABLE `bots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `castle_soldier`
--
ALTER TABLE `castle_soldier`
  MODIFY `castle_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_buddys`
--
ALTER TABLE `character_buddys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_elf_warehouse`
--
ALTER TABLE `character_elf_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_exclude`
--
ALTER TABLE `character_exclude`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_monsterbooklist`
--
ALTER TABLE `character_monsterbooklist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_package_warehouse`
--
ALTER TABLE `character_package_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_present_warehouse`
--
ALTER TABLE `character_present_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_special_warehouse`
--
ALTER TABLE `character_special_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_teleport`
--
ALTER TABLE `character_teleport`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `character_warehouse`
--
ALTER TABLE `character_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_bless_buff`
--
ALTER TABLE `clan_bless_buff`
  MODIFY `number` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_contribution_buff`
--
ALTER TABLE `clan_contribution_buff`
  MODIFY `clan_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_data`
--
ALTER TABLE `clan_data`
  MODIFY `clan_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_history`
--
ALTER TABLE `clan_history`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_warehouse`
--
ALTER TABLE `clan_warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_warehouse_list`
--
ALTER TABLE `clan_warehouse_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clan_warehouse_log`
--
ALTER TABLE `clan_warehouse_log`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `craft_info`
--
ALTER TABLE `craft_info`
  MODIFY `craft_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `craft_npcs`
--
ALTER TABLE `craft_npcs`
  MODIFY `npc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `etcitem`
--
ALTER TABLE `etcitem`
  MODIFY `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inter_race_region`
--
ALTER TABLE `inter_race_region`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_bookmark`
--
ALTER TABLE `item_bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levelup_quests_item`
--
ALTER TABLE `levelup_quests_item`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_chat`
--
ALTER TABLE `log_chat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_cwarehouse`
--
ALTER TABLE `log_cwarehouse`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_enchant`
--
ALTER TABLE `log_enchant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_private_shop`
--
ALTER TABLE `log_private_shop`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_shop`
--
ALTER TABLE `log_shop`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_warehouse`
--
ALTER TABLE `log_warehouse`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mobgroup`
--
ALTER TABLE `mobgroup`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monster_book`
--
ALTER TABLE `monster_book`
  MODIFY `monsternumber` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `npc`
--
ALTER TABLE `npc`
  MODIFY `npcid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polymorphs`
--
ALTER TABLE `polymorphs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `robot_location`
--
ALTER TABLE `robot_location`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `robot_message`
--
ALTER TABLE `robot_message`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `robot_name`
--
ALTER TABLE `robot_name`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `robot_teleport_list`
--
ALTER TABLE `robot_teleport_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `server_explain`
--
ALTER TABLE `server_explain`
  MODIFY `num` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_aden`
--
ALTER TABLE `shop_aden`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist`
--
ALTER TABLE `spawnlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_arrow`
--
ALTER TABLE `spawnlist_arrow`
  MODIFY `npc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_boss`
--
ALTER TABLE `spawnlist_boss`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_boss_sign`
--
ALTER TABLE `spawnlist_boss_sign`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_clandungeon`
--
ALTER TABLE `spawnlist_clandungeon`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_indun`
--
ALTER TABLE `spawnlist_indun`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_light`
--
ALTER TABLE `spawnlist_light`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_npc`
--
ALTER TABLE `spawnlist_npc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_npc_cash_shop`
--
ALTER TABLE `spawnlist_npc_cash_shop`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_npc_shop`
--
ALTER TABLE `spawnlist_npc_shop`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_other`
--
ALTER TABLE `spawnlist_other`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_ruun`
--
ALTER TABLE `spawnlist_ruun`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_ub`
--
ALTER TABLE `spawnlist_ub`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_unicorntemple`
--
ALTER TABLE `spawnlist_unicorntemple`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spawnlist_worldwar`
--
ALTER TABLE `spawnlist_worldwar`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_lfccompensate`
--
ALTER TABLE `tb_lfccompensate`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_lfctypes`
--
ALTER TABLE `tb_lfctypes`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `util_fighter`
--
ALTER TABLE `util_fighter`
  MODIFY `Num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `util_racer`
--
ALTER TABLE `util_racer`
  MODIFY `Num` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weapon`
--
ALTER TABLE `weapon`
  MODIFY `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weapon_skill`
--
ALTER TABLE `weapon_skill`
  MODIFY `weapon_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
