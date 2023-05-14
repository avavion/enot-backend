ROOT=$(pwd)

curl "http://enot/valutes/parse?email=parser@enot.ru&password=parserparser"

current_date_time=$(date)

echo "Current date and time: $current_date_time" >> "$ROOT/logger.txt"