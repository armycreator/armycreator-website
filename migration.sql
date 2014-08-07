UPDATE Stuff s JOIN Weapon e ON e.id = s.id SET s.description = CONCAT('s:',LENGTH(e.rule), ':"', e.rule, '";');
UPDATE Stuff s JOIN Equipement e ON e.id = s.id SET s.description = CONCAT('s:',LENGTH(e.description), ':"', e.description, '";');
