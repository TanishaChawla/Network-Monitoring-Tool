#! /bin/bash
#extracting packets
tcpdump -n -c $1 > files/dump
grep "IP\s" files/dump > files/tcp
grep "UDP" files/dump > files/udp
grep "ARP" files/dump > files/ar

grep "Request" files/ar >files/arp
grep "(.*)\stell" files/arp>files/arp2
grep "[0-9]*\stell" files/arp >files/arp1

cut -d " " -f1 files/arp1>files/arp_time
cut -d " " -f5 files/arp1>files/arp_srcadd
cut -d " " -f7 files/arp1 > files/arp_d
cut -d " " -f9 files/arp1 > files/arp_length
cut -d " " -f1 files/arp2>>files/arp_time
cut -d " " -f5 files/arp2>>files/arp_srcadd
cut -d " " -f8 files/arp2 >> files/arp_d
cut -d " " -f10 files/arp2 >> files/arp_length

cut -d "," -f1 files/arp_d > files/arp_dstadd


grep "length" files/tcp > files/tcp_1
cut -d " " -f1 files/tcp_1>files/tcp_time
cut -d " " -f3 files/tcp_1>files/tcp_source
cut -d " " -f5 files/tcp_1>files/tcp_dest
cut -d " " -f21 files/tcp_1> files/tcp_length
grep "([0-9]+)" files/tcp> files/tcp_2
cut -d " " -f1 files/tcp_2>>files/tcp_time
cut -d " " -f3 files/tcp_2>>files/tcp_source
cut -d " " -f5 files/tcp_2 >> files/tcp_dest
cut -d ":" -f1 files/tcp_dest > files/tcp_destination
cut -d "(" -f2 files/tcp_2 >files/tcp_l
cut -d ")" -f1 files/tcp_2 >>files/tcp_length
cut -d "." -f1,2,3,4 files/tcp_source>files/tcp_srcadd
cut -d "." -f5 files/tcp_source >files/tcp_srcport
cut -d "." -f1,2,3,4 files/tcp_destination>files/tcp_dstadd
cut -d "." -f5 files/tcp_destination > files/tcp_dstport

grep "BROADCAST" files/udp > files/udp1
grep "length" files/udp > files/udp2

cut -d " " -f1 files/udp1 > files/udp_time
cut -d " " -f3 files/udp1 > files/udp_source
cut -d " " -f5 files/udp1 > files/udp_destination
cut -d "(" -f2 files/udp1>files/udp_l
cut -d ")" -f1 files/udp_l>files/udp_length
cut -d " " -f9 files/udp1 >> files/udp_length
cut -d " " -f1 files/udp2 >> files/udp_time
cut -d " " -f3 files/udp2 >> files/udp_source
cut -d " " -f5 files/udp2 >> files/udp_destination
cut -d " " -f8 files/udp2 >> files/udp_length

cut -d "." -f1,2,3,4 files/udp_source> files/udp_srcadd
cut -d "." -f5 files/udp_source>files/udp_srcport
cut -d "." -f1,2,3,4 files/udp_destination> files/udp_dstadd
cut -d "." -f5 files/udp_destination >files/udp_dstp
cut -d ":" -f1 files/udp_dstp > files/udp_dstport

echo `exit`
