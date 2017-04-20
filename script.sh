#! /bin/bash
#extracting packets
tcpdump -n -c 1000 > dump
grep "IP\s" dump > tcp
grep "UDP" dump > udp
grep "ARP" dump > ar

grep "Request" ar >arp
grep "(.*)\stell" arp>arp2
grep "[0-9]*\stell" arp >arp1

cut -d " " -f1 arp1>arp_time
cut -d " " -f5 arp1>arp_srcadd
cut -d " " -f7 arp1 > arp_d
cut -d " " -f9 arp1 > arp_length
cut -d " " -f1 arp2>>arp_time
cut -d " " -f5 arp2>>arp_srcadd
cut -d " " -f8 arp2 >> arp_d
cut -d " " -f10 arp2 >> arp_length

cut -d "," -f1 arp_d > arp_dstadd


grep "length" tcp > tcp_1
cut -d " " -f1 tcp_1>tcp_time
cut -d " " -f3 tcp_1>tcp_source
cut -d " " -f5 tcp_1>tcp_dest
cut -d " " -f21 tcp_1> tcp_length
grep "([0-9]+)" tcp> tcp_2
cut -d " " -f1 tcp_2>>tcp_time
cut -d " " -f3 tcp_2>>tcp_source
cut -d " " -f5 tcp_2 >> tcp_dest
cut -d ":" -f1 tcp_dest > tcp_destination
cut -d "(" -f2 tcp_2 >tcp_l
cut -d ")" -f1 tcp_2 >>tcp_length
cut -d "." -f1,2,3,4 tcp_source>tcp_srcadd
cut -d "." -f5 tcp_source >tcp_srcport
cut -d "." -f1,2,3,4 tcp_destination>tcp_dstadd
cut -d "." -f5 tcp_destination > tcp_dstport

grep "BROADCAST" udp > udp1
grep "length" udp > udp2

cut -d " " -f1 udp1 > udp_time
cut -d " " -f3 udp1 > udp_source
cut -d " " -f5 udp1 > udp_destination
cut -d "(" -f2 udp1>udp_l
cut -d ")" -f1 udp_l>udp_length
cut -d " " -f9 udp1 >> udp_length
cut -d " " -f1 udp2 >> udp_time
cut -d " " -f3 udp2 >> udp_source
cut -d " " -f5 udp2 >> udp_destination
cut -d " " -f8 udp2 >> udp_length

cut -d "." -f1,2,3,4 udp_source> udp_srcadd
cut -d "." -f5 udp_source>udp_srcport
cut -d "." -f1,2,3,4 udp_destination> udp_dstadd
cut -d "." -f5 udp_destination >udp_dstp
cut -d ":" -f1 udp_dstp > udp_dstport

echo `exit`
