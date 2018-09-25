#! /usr/bin/perl

# Hlavi?ky
print "Content-type: text/html; charset=utf-8\n\n";

# HTML odpov??
print '<!DOCTYPE html>', "\n";
print '<html>', "\n";
print '<head>', "\n";
print '  <meta charset="utf-8">', "\n";
print '  <title>Demo stránka</title>', "\n";
print '</head>', "\n";
print '<body>', "\n";
print '<h1>Ukázková stránka</h1>', "\n";

for ($i = 1; $i <= 10; $i++) {
    print "Řádek $i<br>\n";
}

print '</body></html>', "\n";
