<?xml version="1.0" encoding="UTF-8" ?>

<xsl:stylesheet version="1.1"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	
    <xsl:output method="html"
    			version="5.0"
    			indent="yes"
    			encoding="utf-8"
    			cdata-section-elements=""
    			doctype-public="" />
 
	<xsl:template match="/">
		<html>
		<head>
			<title>Seznam osob</title>
			<meta charset="utf-8" />
			<style type="text/css">
                html {
                    font: 12pt Arial;
                }
                section {
                    float: left;
                    margin: 1em;
                    padding: 1em;
                    width: 20em;
                    border: 1px solid blue;
                    background-color: #eee;
                    box-shadow: 10px 10px 10px #555;
                }
                header {
                    border-bottom: 1px solid #333;
                }
                header p {
                    font-style: italic;
                    text-align: right;
                }
			</style>
		</head>
		<body>
            <xsl:apply-templates />
		</body>
		</html>
	</xsl:template>

	<xsl:template match="person">
        <section class="person">
            <header>
                <h1><xsl:value-of select="lastName" />, <xsl:value-of select="firstName" /></h1>
                <xsl:apply-templates select="description" />
            </header>
            <xsl:apply-templates select="address" />
            <xsl:apply-templates select="phoneNumbers" />
        </section>
	</xsl:template>
	
    <xsl:template match="address">
        <p class="address">
            <xsl:value-of select="streetAddress" />,<br />
            <xsl:value-of select="postalCode" />,
            <xsl:value-of select="city" />,
            <xsl:value-of select="state" /><br />
            <i>(<xsl:value-of select="ancestor::person/child::firstName" />'s primary contact)</i>
        </p>
    </xsl:template>
    
    <xsl:template match="phoneNumbers">
        <xsl:if test="count(item) > 0">
            <p class="phones">Tel. <xsl:apply-templates select="item" /></p>
        </xsl:if>
        <xsl:if test="count(item) = 0">
            <p><i>(telephone unknown)</i></p>
        </xsl:if>
    </xsl:template>
    
    <xsl:template match="item">
        <xsl:if test="position() > 1">
            <xsl:text>, </xsl:text>
        </xsl:if>
        <span><xsl:value-of select="." /></span>
    </xsl:template>

    <xsl:template match="description">
        <p><xsl:value-of select="." /></p>
    </xsl:template>
    
</xsl:stylesheet>
