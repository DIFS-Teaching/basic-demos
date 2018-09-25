#! /usr/bin/perl

# Headers
print "Content-type: text/html; charset=utf-8\n\n";

# HTML response
print '<!DOCTYPE html>', "\n";
print '<html>', "\n";
print '<head>', "\n";
print '  <meta charset="utf-8">', "\n";
print '  <title>CGI demo in Perl</title>', "\n";
print '</head>', "\n";
print '<body>', "\n";
print '<h1>A Sample Page</h1>', "\n";

for ($i = 1; $i <= 10; $i++) {
    print "Line $i<br>\n";
}

print '</body></html>', "\n";
