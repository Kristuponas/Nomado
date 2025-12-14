<?php
function get_comments($db, $count, $offset, $id = null) {
    $params = ['count' => $count, 'offset' => $offset];
    $sql = "
        SELECT
            va.vartotojo_vardas,
            k.turinys,
            ve.bendras
        FROM komentaras k
        LEFT JOIN vartotojas va
            ON va.id = k.fk_Vartotojas
        LEFT JOIN vertinimas ve
            ON ve.fk_Komentaras = k.id";

    if (!is_null($id)) {
	$sql = $sql . " WHERE k.fk_Viesbutis = :id";
	$params['id'] = $id;
        $count = $db->count('komentaras', ['fk_Viesbutis' => $id]);
    } else {
        $count = $db->count('komentaras');
    }

    $sql = $sql . " LIMIT :count OFFSET :offset";
    $res = $db->query($sql, $params);

    return ['count' => $count, 'result' => $res];
}
