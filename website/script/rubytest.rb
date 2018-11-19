#!/usr/bin/ruby

require 'mysql'


begin
    con = Mysql.new 'db717746068.db.1and1.com', 'dbo717746068', 'Th3 derpy DBA!'
    puts con.get_server_info
    rs = con.query 'SELECT VERSION()'
    puts rs.fetch_row    
    
rescue Mysql::Error => e
    puts e.errno
    puts e.error
    
ensure
    con.close if con
end
