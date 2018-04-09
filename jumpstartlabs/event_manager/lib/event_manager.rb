#event engagement app - A number of people have registered for an upcoming event. She has asked for your help in engaging these future attendees.
require 'csv'
require 'sunlight/congress'

Sunlight::Congress.api_key = "e179a6973728c4dd3fb1204283aaccb5"


def clean_zipcode(zipcode)
  zipcode.to_s.rjust(5,"0")[0..4]
end

puts "EventManager initialized."

contents = CSV.open 'event_attendees.csv', headers: true, header_converters: :symbol

contents.each do |row|
  name = row[:first_name]

  legislators = Sunlight::Congress::Legislator.by_zipcode(zipcode)

  puts "#{name} #{zipcode} #{legislators}"
end



