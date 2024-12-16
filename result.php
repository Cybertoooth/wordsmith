<?php
$json_stream = json_decode(file_get_contents("php://input"), true);
$json_url = $json_stream["url"];
$data = json_decode(file_get_contents($json_url), true)[0];
$word = $data["word"];
$phonetic = $data["phonetics"][0]["text"]
    ? $data["phonetics"][0]["text"]
    : $data["phonetics"][1]["text"];
$audio = $data["phonetics"][0]["audio"]
    ? $data["phonetics"][0]["audio"]
    : $data["phonetics"][1]["audio"];
$wordArray = [
    "word" => $word,
    "phonetic" => $phonetic,
    "audio" => $audio,
    "definition" => [],
];
$meanings = $data["meanings"];
foreach ($meanings as $value) {
    for ($i = 0; $i < count($value["definitions"]); $i++) {
        array_push($wordArray["definition"], [
            "partOfSpeech" => $value["partOfSpeech"],
        ]);
        if (isset($value["definitions"][$i]["example"])) {
            array_push($wordArray["definition"], [
                "example" => $value["definitions"][$i]["example"],
            ]);
        }
        array_push($wordArray["definition"], [
            "definition" => $value["definitions"][$i]["definition"],
        ]);
    }
}

echo json_encode($wordArray);

?>
