import React, { useState, useRef, useEffect } from 'react';
import { StyleSheet, Text, View, ScrollView, Pressable, Platform, Dimensions, Animated, Easing } from 'react-native';
import { MaterialCommunityIcons, Ionicons } from '@expo/vector-icons';
import { useSafeAreaInsets } from 'react-native-safe-area-context';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter, Link } from 'expo-router';
import { CURRENT_STORE } from './todays-plan';

type ShiftState = 'upcoming' | 'active' | 'break' | 'completed';

const MOTIVATIONAL_QUOTES = [
  "Let's make today amazing! ✨", "You've got this! 💪", "Keep up the great work! 🚀", 
  "Another day, another win! 🏆", "Bring your best today! 🔥", "Stay positive, work hard! 🌟", 
  "Make it happen! ⚡", "You're doing great! 👏", "Believe in yourself! 🌈", 
  "Your potential is limitless! 🚀", "Stay focused and win! 🎯", "Ready to crush it? 💥", 
  "Start strong, finish stronger! 💯", "Great things take time! ⏳", "Success is a journey! 🛤️", 
  "Embrace the challenge! 🌪️", "Shine bright today! ☀️", "Make every moment count! ⏱️", 
  "Keep pushing forward! 🏃", "Be the energy you want to attract! 🔋", "Dream big, work hard! 🌟", 
  "Stay sharp, stay focused! 🧠", "A great day starts now! 🌅", "Progress, not perfection! 📈", 
  "Make today a masterpiece! 🎨", "Conquer the day! ⚔️", "Your best is yet to come! 🌠", 
  "Turn goals into reality! 🛠️", "Keep moving forward! ➡️", "Today is your day! 🎉",
  "One step at a time! 👣", "Good vibes only! ✌️", "Rise and grind! ☕",
  "Keep the momentum going! 🔄", "Every effort counts! 💯", "Unleash your potential! 🔓",
  "Strive for greatness! 👑", "Never stop learning! 📚", "Create your own success! 🏗️",
  "Focus on the good! 🔍", "Stay humble, hustle hard! 💼", "You are unstoppable! 🚂",
  "Keep smiling, keep shining! 😁", "Make it a habit! 🔁", "Doubt kills more dreams than failure! 💭",
  "Take the leap! 🪂", "Find your fire! 🔥", "Stay hungry, stay foolish! 🍎",
  "Focus, execute, succeed! 🎯", "You're on the right track! 🛤️", "Elevate your game! 🎮",
  "Leave your mark! 🐾", "Embrace the hustle! 🏃", "Small wins matter! 🐜",
  "Make them proud! 💫", "Trust the process! 🧩", "No excuses, just results! 🚫",
  "Today is an opportunity! 🚪", "Keep your eyes on the prize! 🎁", "You define your success! 📝"
];

const shuffleArray = (array: string[]) => {
  const newArr = [...array];
  for (let i = newArr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [newArr[i], newArr[j]] = [newArr[j], newArr[i]];
  }
  return newArr;
};

export default function EmployeeHome() {
  const router = useRouter();
  const insets = useSafeAreaInsets();
  const scrollY = useRef(new Animated.Value(0)).current;
  const [shiftState, setShiftState] = useState<ShiftState>('upcoming');
  const [hasTakenBreak, setHasTakenBreak] = useState(false);
  
  const quoteOpacity = useRef(new Animated.Value(0)).current;
  const quoteTranslateY = useRef(new Animated.Value(10)).current;
  const quoteQueue = useRef(shuffleArray(MOTIVATIONAL_QUOTES));
  const quoteIndex = useRef(0);
  const [quote, setQuote] = useState(quoteQueue.current[0]);

  const currentHour = new Date().getHours();
  let greetingText = 'Good evening';
  if (currentHour >= 5 && currentHour < 12) greetingText = 'Good morning';
  else if (currentHour >= 12 && currentHour < 18) greetingText = 'Good afternoon';

  // Entrance animations
  const fadeAnim = useRef(new Animated.Value(0)).current;
  const slideAnim = useRef(new Animated.Value(20)).current;

  useEffect(() => {
    Animated.parallel([
      Animated.timing(quoteOpacity, { toValue: 1, duration: 600, useNativeDriver: true }),
      Animated.timing(quoteTranslateY, { toValue: 0, duration: 600, useNativeDriver: true, easing: Easing.out(Easing.cubic) }),
      Animated.timing(fadeAnim, { toValue: 1, duration: 400, useNativeDriver: true, easing: Easing.out(Easing.cubic) }),
      Animated.timing(slideAnim, { toValue: 0, duration: 500, useNativeDriver: true, easing: Easing.out(Easing.cubic) })
    ]).start();

    const interval = setInterval(() => {
      Animated.parallel([
        Animated.timing(quoteOpacity, { toValue: 0, duration: 300, useNativeDriver: true }),
        Animated.timing(quoteTranslateY, { toValue: -5, duration: 300, useNativeDriver: true })
      ]).start(() => {
        quoteIndex.current++;
        if (quoteIndex.current >= quoteQueue.current.length) {
          quoteQueue.current = shuffleArray(MOTIVATIONAL_QUOTES);
          quoteIndex.current = 0;
        }
        setQuote(quoteQueue.current[quoteIndex.current]);
        
        quoteTranslateY.setValue(5);
        Animated.parallel([
          Animated.timing(quoteOpacity, { toValue: 1, duration: 400, useNativeDriver: true }),
          Animated.timing(quoteTranslateY, { toValue: 0, duration: 400, useNativeDriver: true, easing: Easing.out(Easing.cubic) })
        ]).start();
      });
    }, 8000);

    return () => clearInterval(interval);
  }, []);

  const HEADER_MAX_HEIGHT = 120 + insets.top;
  const HEADER_MIN_HEIGHT = 60 + insets.top;
  const SCROLL_DISTANCE = HEADER_MAX_HEIGHT - HEADER_MIN_HEIGHT;

  const headerHeight = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE],
    outputRange: [HEADER_MAX_HEIGHT, HEADER_MIN_HEIGHT],
    extrapolate: 'clamp',
  });

  const largeTitleOpacity = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE / 2],
    outputRange: [1, 0],
    extrapolate: 'clamp',
  });

  const largeTitleTranslate = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE],
    outputRange: [0, -15],
    extrapolate: 'clamp',
  });

  const compactTitleOpacity = scrollY.interpolate({
    inputRange: [SCROLL_DISTANCE / 2, SCROLL_DISTANCE],
    outputRange: [0, 1],
    extrapolate: 'clamp',
  });

  const headerShadow = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE],
    outputRange: [0, 0.06],
    extrapolate: 'clamp',
  });

  const handleClockAction = () => {
    if (shiftState === 'upcoming') setShiftState('active');
    else if (shiftState === 'active') setShiftState('completed');
  };

  const handleBreakAction = () => {
    if (shiftState === 'active') setShiftState('break');
    else if (shiftState === 'break') {
      setHasTakenBreak(true);
      setShiftState('active');
    }
  };

  const pulseAnim = useRef(new Animated.Value(1)).current;
  const clockInScale = useRef(new Animated.Value(1)).current;
  const timelineProgress = useRef(new Animated.Value(0)).current;

  useEffect(() => {
    Animated.loop(
      Animated.sequence([
        Animated.timing(pulseAnim, { toValue: 1.15, duration: 800, useNativeDriver: true, easing: Easing.inOut(Easing.ease) }),
        Animated.timing(pulseAnim, { toValue: 1, duration: 800, useNativeDriver: true, easing: Easing.inOut(Easing.ease) })
      ])
    ).start();
  }, []);

  useEffect(() => {
    let target = 0;
    if (shiftState === 'active' && !hasTakenBreak) target = 38;
    else if (shiftState === 'break') target = 60;
    else if (shiftState === 'active' && hasTakenBreak) target = 85;
    else if (shiftState === 'completed') target = 100;
    
    Animated.timing(timelineProgress, {
      toValue: target,
      duration: 1200,
      easing: Easing.out(Easing.cubic),
      useNativeDriver: false
    }).start();
  }, [shiftState, hasTakenBreak]);

  const handlePressIn = () => Animated.timing(clockInScale, { toValue: 0.97, duration: 150, useNativeDriver: true }).start();
  const handlePressOut = () => Animated.timing(clockInScale, { toValue: 1, duration: 150, useNativeDriver: true }).start();

  const getContextContent = () => {
    switch(shiftState) {
      case 'upcoming': 
        return { icon: 'time', color: '#FF6B21', title: <Text>Shift starts in <Text style={styles.contextHighlight}>28 min</Text></Text>, sub: 'Get ready for your shift' };
      case 'active': 
        if (!hasTakenBreak) {
          return { icon: 'pulse', color: '#2E7D32', title: <Text>4h <Text style={{fontWeight:'700'}}>worked</Text></Text>, sub: <Text>Next break at 11:00 <Text style={styles.timeAmPm}>a.m.</Text></Text> };
        } else {
          return { icon: 'pulse', color: '#2E7D32', title: <Text>8h <Text style={{fontWeight:'700'}}>worked</Text></Text>, sub: <Text>Shift ends at 16:00 <Text style={styles.timeAmPm}>p.m.</Text></Text> };
        }
      case 'break': 
        return { icon: 'cafe', color: '#F57C00', title: <Text>On break since <Text style={{fontWeight:'700'}}>11:00 <Text style={styles.timeAmPm}>a.m.</Text></Text></Text>, sub: 'Relax and recharge' };
      case 'completed': 
        return { icon: 'checkmark-circle', color: '#737373', title: <Text>Shift <Text style={{fontWeight:'700'}}>completed</Text></Text>, sub: 'Great job today!' };
    }
  }
  const ctx = getContextContent();

  return (
    <View style={styles.container}>
      {/* Sticky App Bar */}
      <Animated.View style={[
        styles.appBar, 
        { 
          height: headerHeight,
          paddingTop: insets.top,
          shadowOpacity: headerShadow,
          elevation: scrollY.interpolate({ inputRange: [0, SCROLL_DISTANCE], outputRange: [0, 6] })
        }
      ]}>
        <View style={styles.appBarTop}>
          <Animated.View style={[styles.compactTitleWrapper, { opacity: compactTitleOpacity }]}>
            <Text style={styles.compactTitle}>{greetingText}, Renzo</Text>
          </Animated.View>
          <View style={styles.appBarRight}>
            <Pressable style={({pressed}) => [styles.iconButton, pressed && {opacity: 0.7}]}>
              <Ionicons name="notifications-outline" size={24} color="#171717" />
              <View style={styles.badge} />
            </Pressable>
            <View style={styles.avatarContainer}>
              <Text style={styles.avatarText}>RG</Text>
            </View>
          </View>
        </View>

        <Animated.View 
          style={[
            styles.largeTitleWrapper, 
            { 
              opacity: largeTitleOpacity,
              transform: [{ translateY: largeTitleTranslate }]
            }
          ]}
          pointerEvents="none"
        >
          <Text style={styles.greeting}>{greetingText}, Renzo</Text>
          <Animated.Text style={[styles.subGreeting, { opacity: quoteOpacity, transform: [{ translateY: quoteTranslateY }] }]}>
            {quote}
          </Animated.Text>
        </Animated.View>
      </Animated.View>

      <Animated.ScrollView 
        contentContainerStyle={[styles.scrollContent, { paddingTop: HEADER_MAX_HEIGHT + 16, paddingBottom: 120 }]}
        showsVerticalScrollIndicator={false}
        onScroll={Animated.event(
          [{ nativeEvent: { contentOffset: { y: scrollY } } }],
          { useNativeDriver: false }
        )}
        scrollEventThrottle={16}
      >
        <Animated.View style={{ opacity: fadeAnim, transform: [{ translateY: slideAnim }] }}>
          {/* TODAY Hero Card */}
          <View style={styles.heroCard}>
            <View style={styles.heroHeader}>
              <View style={styles.todayBadge}>
                <Ionicons name="calendar" size={16} color="#E6392F" />
                <Text style={styles.todayBadgeText}>TODAY</Text>
              </View>
              <View style={[
                styles.statusBadge, 
                shiftState === 'active' && styles.statusBadgeActive,
                shiftState === 'break' && styles.statusBadgeBreak,
                shiftState === 'completed' && styles.statusBadgeCompleted
              ]}>
                <View style={[
                  styles.statusDot, 
                  shiftState === 'active' && styles.statusDotActive,
                  shiftState === 'break' && styles.statusDotBreak,
                  shiftState === 'completed' && styles.statusDotCompleted
                ]} />
                <Text style={[
                  styles.statusText,
                  shiftState === 'active' && styles.statusTextActive,
                  shiftState === 'break' && styles.statusTextBreak,
                  shiftState === 'completed' && styles.statusTextCompleted
                ]}>
                  {shiftState === 'upcoming' ? 'Not clocked in' : 
                   shiftState === 'active' ? 'Clocked In' : 
                   shiftState === 'break' ? 'On Break' : 'Completed'}
                </Text>
              </View>
            </View>

            <View style={styles.shiftInfo}>
              <Text style={styles.shiftTime} adjustsFontSizeToFit numberOfLines={1}>07:00 <Text style={styles.shiftTimeAmPm}>a.m.</Text> — 16:00 <Text style={styles.shiftTimeAmPm}>p.m.</Text></Text>
              <View style={styles.shiftDetailsList}>
                <View style={styles.shiftDetailItem}>
                  <Ionicons name="storefront-outline" size={18} color="#555" />
                  <Text style={styles.shiftDetailTextMain}>Food & Consumables</Text>
                </View>
                <View style={styles.shiftDetailItem}>
                  <Ionicons name="location" size={18} color="#777" />
                  <Text style={styles.shiftDetailTextSub}>{CURRENT_STORE.shortName}</Text>
                </View>
              </View>
            </View>

            {/* Contextual Panel */}
            <View style={styles.contextPanel}>
              <View style={styles.contextIconWrap}>
                <Animated.View style={{ transform: [{ scale: shiftState === 'upcoming' ? pulseAnim : 1 }] }}>
                  <Ionicons name={ctx.icon as any} size={22} color={ctx.color} />
                </Animated.View>
              </View>
              <View style={styles.contextTextWrap}>
                <Text style={styles.contextTitle}>{ctx.title}</Text>
                <Text style={styles.contextSubtitle}>{ctx.sub}</Text>
              </View>
              {shiftState === 'upcoming' && (
                <View style={styles.contextArrowWrap}>
                  <Ionicons name="chevron-forward" size={16} color="#E6392F" />
                </View>
              )}
            </View>

            {/* Dynamic Actions */}
            {shiftState !== 'completed' && (
              <View style={styles.actionRow}>
                {shiftState === 'active' && hasTakenBreak ? (
                  <Pressable 
                    onPress={handleClockAction}
                    onPressIn={handlePressIn}
                    onPressOut={handlePressOut}
                    style={styles.primaryBtnWrapperFull}
                  >
                    <Animated.View style={[styles.gradientBtnFullWrap, { transform: [{ scale: clockInScale }] }]}>
                      <LinearGradient colors={['#E6392F', '#FF6B21']} start={{ x: 0, y: 0 }} end={{ x: 1, y: 1 }} style={styles.gradientBtnFull}>
                        <View style={styles.clockIconCircle}>
                          <Ionicons name="exit-outline" size={18} color="#FFF" />
                        </View>
                        <Text style={styles.primaryBtnTextFull}>Clock Out</Text>
                      </LinearGradient>
                    </Animated.View>
                  </Pressable>
                ) : shiftState === 'active' || shiftState === 'break' ? (
                  <View style={styles.splitActions}>
                    <Pressable 
                      onPress={handleBreakAction}
                      style={({ pressed }) => [styles.secondaryBtn, pressed && styles.btnPressed]}
                    >
                      <Ionicons name={shiftState === 'break' ? 'play-outline' : 'pause-outline'} size={18} color="#171717" style={{marginRight: 6}} />
                      <Text style={styles.secondaryBtnText}>
                        {shiftState === 'break' ? 'End Break' : 'Start Break'}
                      </Text>
                    </Pressable>
                    <Pressable 
                      onPress={handleClockAction}
                      onPressIn={handlePressIn}
                      onPressOut={handlePressOut}
                      style={styles.primaryBtn}
                    >
                      <Animated.View style={[styles.gradientBtnWrapper, { transform: [{ scale: clockInScale }] }]}>
                        <LinearGradient colors={['#E6392F', '#FF6B21']} start={{ x: 0, y: 0 }} end={{ x: 1, y: 1 }} style={styles.gradientBtn}>
                          <Ionicons name="exit-outline" size={18} color="#FFF" style={{marginRight: 6}} />
                          <Text style={styles.primaryBtnText}>Clock Out</Text>
                        </LinearGradient>
                      </Animated.View>
                    </Pressable>
                  </View>
                ) : (
                  <Pressable 
                    onPress={handleClockAction}
                    onPressIn={handlePressIn}
                    onPressOut={handlePressOut}
                    style={styles.primaryBtnWrapperFull}
                  >
                    <Animated.View style={[styles.gradientBtnFullWrap, { transform: [{ scale: clockInScale }] }]}>
                      <LinearGradient colors={['#E6392F', '#FF6B21', '#FFB020']} start={{ x: 0, y: 0 }} end={{ x: 1, y: 1 }} style={styles.gradientBtnFull}>
                        <View style={styles.clockIconCircle}>
                          <Ionicons name="time-outline" size={18} color="#FFF" />
                        </View>
                        <Text style={styles.primaryBtnTextFull}>Clock In</Text>
                      </LinearGradient>
                    </Animated.View>
                  </Pressable>
                )}
              </View>
            )}

            {/* Shift Summary */}
            <View style={styles.shiftSummaryRow}>
              <View style={[styles.summaryPill, { backgroundColor: '#E8F0FE' }]}>
                <Ionicons name="calendar" size={14} color="#1967D2" style={{marginRight: 6}} />
                <Text style={[styles.summaryText, { color: '#1967D2' }]}>9h scheduled</Text>
              </View>
              <View style={[styles.summaryPill, { backgroundColor: '#FFF3E0' }]}>
                <Ionicons name="cafe" size={14} color="#F57C00" style={{marginRight: 6}} />
                <Text style={[styles.summaryText, { color: '#F57C00' }]}>1h break</Text>
              </View>
              <View style={[styles.summaryPill, { backgroundColor: '#E8F5E9' }]}>
                <Ionicons name="list" size={14} color="#2E7D32" style={{marginRight: 6}} />
                <Text style={[styles.summaryText, { color: '#2E7D32' }]}>2 shifts today</Text>
              </View>
            </View>

            {/* Professional Timeline */}
            <View style={styles.timeline}>
              <View style={styles.timelineLabelsTop}>
                <Text style={styles.timelineTime}>07:00 <Text style={styles.timelineAmPm}>a.m.</Text></Text>
                <Text style={styles.timelineTime}>11:00 <Text style={styles.timelineAmPm}>a.m.</Text></Text>
                <Text style={styles.timelineTime}>12:00 <Text style={styles.timelineAmPm}>p.m.</Text></Text>
                <Text style={styles.timelineTime}>16:00 <Text style={styles.timelineAmPm}>p.m.</Text></Text>
              </View>
              
              <View style={styles.timelineTrackContainer}>
                <View style={styles.timelineTrackBg} />
                <Animated.View style={[styles.timelineTrackFill, { width: timelineProgress.interpolate({ inputRange: [0, 100], outputRange: ['0%', '100%'] }) }]}>
                  <LinearGradient colors={['#E6392F', '#FF6B21', '#FFB020', '#E6392F']} start={{x: 0, y: 0}} end={{x: 1, y: 0}} style={StyleSheet.absoluteFill} />
                </Animated.View>
                
                {/* Nodes with glow */}
                <View style={[styles.timelineNodeWrapper, { left: '0%' }]}>
                  <View style={[styles.timelineNodeGlow, { backgroundColor: 'rgba(230,57,47,0.15)' }]} />
                  <View style={[styles.timelineNode, { borderColor: '#E6392F' }]} />
                </View>
                
                <View style={[styles.timelineNodeWrapper, { left: '38%' }]}>
                  <View style={[styles.timelineNodeGlow, { backgroundColor: 'rgba(255,176,32,0.15)' }]} />
                  <View style={[styles.timelineNode, { borderColor: '#FFB020' }]} />
                </View>
                
                <View style={[styles.timelineNodeWrapper, { left: '60%' }]}>
                  <View style={[styles.timelineNodeGlow, { backgroundColor: 'rgba(255,176,32,0.15)' }]} />
                  <View style={[styles.timelineNode, { borderColor: '#FFB020' }]} />
                </View>
                
                <View style={[styles.timelineNodeWrapper, { left: '100%' }]}>
                  <View style={[styles.timelineNodeGlow, { backgroundColor: 'rgba(230,57,47,0.15)' }]} />
                  <View style={[styles.timelineNode, { borderColor: '#E6392F' }]} />
                </View>
              </View>
              
              <View style={styles.timelineLabelsBottom}>
                <View style={[styles.timelineLabelCol, { alignItems: 'flex-start' }]}>
                  <Ionicons name="sunny-outline" size={16} color="#737373" style={{marginBottom: 2}} />
                  <Text style={styles.timelineLabel}>Start</Text>
                </View>
                <View style={[styles.timelineLabelCol, { position: 'absolute', left: '38%', transform: [{translateX: -25}], alignItems: 'center', width: 60 }]}>
                  <Ionicons name="cafe-outline" size={16} color="#737373" style={{marginBottom: 2}} />
                  <Text style={styles.timelineLabel}>Break start</Text>
                </View>
                <View style={[styles.timelineLabelCol, { position: 'absolute', left: '60%', transform: [{translateX: -25}], alignItems: 'center', width: 60 }]}>
                  <Ionicons name="cafe-outline" size={16} color="#737373" style={{marginBottom: 2}} />
                  <Text style={styles.timelineLabel}>Break end</Text>
                </View>
                <View style={[styles.timelineLabelCol, { alignItems: 'flex-end' }]}>
                  <Ionicons name="flag-outline" size={16} color="#737373" style={{marginBottom: 2}} />
                  <Text style={styles.timelineLabel}>End</Text>
                </View>
              </View>
            </View>
          </View>



          {/* Upcoming Shifts */}
          <View style={styles.section}>
            <View style={styles.sectionHeader}>
              <Text style={styles.sectionTitle}>UPCOMING</Text>
              <Link href="/schedule" asChild>
                <Pressable hitSlop={10}>
                  <Text style={styles.linkText}>View full schedule</Text>
                </Pressable>
              </Link>
            </View>
            
            <Pressable style={({pressed}) => [styles.upcomingCard, pressed && styles.cardPressed]}>
              <View style={[styles.accentLine, { backgroundColor: '#FF6B21' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Tomorrow</Text>
                  <View style={styles.confirmedBadge}>
                    <Text style={styles.confirmedText}>Confirmed</Text>
                  </View>
                </View>
                <Text style={styles.upcomingRole}>Stocking • 08:00 <Text style={styles.upcomingAmPm}>a.m.</Text> — 17:00 <Text style={styles.upcomingAmPm}>p.m.</Text></Text>
              </View>
              <MaterialCommunityIcons name="chevron-right" size={20} color="#D4D4D4" style={styles.chevron} />
            </Pressable>

            <View style={styles.upcomingCard}>
              <View style={[styles.accentLine, { backgroundColor: '#E0E0E0' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Wed, Oct 17</Text>
                  <View style={[styles.confirmedBadge, { backgroundColor: '#F5F5F5' }]}>
                    <Text style={[styles.confirmedText, { color: '#737373' }]}>Day Off</Text>
                  </View>
                </View>
                <Text style={[styles.upcomingRole, { color: '#9E9E9E' }]}>No shift scheduled</Text>
              </View>
            </View>
            
            <Pressable style={({pressed}) => [styles.upcomingCard, pressed && styles.cardPressed]}>
              <View style={[styles.accentLine, { backgroundColor: '#E6392F' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Thu, Oct 18</Text>
                  <View style={styles.conflictBadge}>
                    <Text style={styles.conflictText}>Action Required</Text>
                  </View>
                </View>
                <Text style={styles.upcomingRole}>Coverage • 12:00 <Text style={styles.upcomingAmPm}>p.m.</Text> — 20:00 <Text style={styles.upcomingAmPm}>p.m.</Text></Text>
              </View>
              <MaterialCommunityIcons name="chevron-right" size={20} color="#D4D4D4" style={styles.chevron} />
            </Pressable>

            <View style={styles.upcomingCard}>
              <View style={[styles.accentLine, { backgroundColor: '#E0E0E0' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Fri, Oct 19</Text>
                  <View style={[styles.confirmedBadge, { backgroundColor: '#F5F5F5' }]}>
                    <Text style={[styles.confirmedText, { color: '#737373' }]}>Day Off</Text>
                  </View>
                </View>
                <Text style={[styles.upcomingRole, { color: '#9E9E9E' }]}>No shift scheduled</Text>
              </View>
            </View>

            <Pressable style={({pressed}) => [styles.upcomingCard, pressed && styles.cardPressed]}>
              <View style={[styles.accentLine, { backgroundColor: '#FFB020' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Sat, Oct 20</Text>
                  <View style={styles.confirmedBadge}>
                    <Text style={styles.confirmedText}>Confirmed</Text>
                  </View>
                </View>
                <Text style={styles.upcomingRole}>Inventory • 06:00 <Text style={styles.upcomingAmPm}>a.m.</Text> — 14:00 <Text style={styles.upcomingAmPm}>p.m.</Text></Text>
              </View>
              <MaterialCommunityIcons name="chevron-right" size={20} color="#D4D4D4" style={styles.chevron} />
            </Pressable>
          </View>

        </Animated.View>
      </Animated.ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F7F7F5',
  },
  appBar: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    backgroundColor: '#F7F7F5',
    zIndex: 10,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 8,
  },
  appBarTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: 20,
    height: 60,
  },
  compactTitleWrapper: {
    flex: 1,
    justifyContent: 'center',
  },
  compactTitle: {
    fontSize: 16,
    fontWeight: '700',
    color: '#171717',
  },
  appBarRight: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  iconButton: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: '#FFFFFF',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 4,
    elevation: 2,
  },
  badge: {
    position: 'absolute',
    top: 8,
    right: 10,
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: '#E6392F',
    borderWidth: 1.5,
    borderColor: '#FFFFFF',
  },
  avatarContainer: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: '#222222',
    alignItems: 'center',
    justifyContent: 'center',
  },
  avatarText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '600',
  },
  largeTitleWrapper: {
    position: 'absolute',
    bottom: 12,
    left: 20,
    right: 20,
  },
  greeting: {
    fontSize: 24,
    fontWeight: '800',
    color: '#171717',
    letterSpacing: -0.5,
  },
  subGreeting: {
    fontSize: 14,
    color: '#737373',
    marginTop: 4,
    fontWeight: '500',
  },
  scrollContent: {
    paddingHorizontal: 16,
  },
  
  heroCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 28,
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 12 },
    shadowOpacity: 0.08,
    shadowRadius: 24,
    elevation: 8,
    marginBottom: 24,
  },
  heroHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 20,
  },
  todayBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#FFF0ED',
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderRadius: 16,
  },
  todayBadgeText: {
    fontSize: 13,
    fontWeight: '800',
    color: '#D32F2F',
    marginLeft: 6,
    letterSpacing: 0.5,
  },
  statusBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#F5F5F5',
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderRadius: 12,
  },
  statusBadgeActive: {
    backgroundColor: '#E8F5E9',
  },
  statusBadgeBreak: {
    backgroundColor: '#FFF8E1',
  },
  statusBadgeCompleted: {
    backgroundColor: '#F5F5F5',
  },
  statusDot: {
    width: 6,
    height: 6,
    borderRadius: 3,
    backgroundColor: '#9E9E9E',
    marginRight: 6,
  },
  statusDotActive: {
    backgroundColor: '#2E7D32',
  },
  statusDotBreak: {
    backgroundColor: '#FFB020',
  },
  statusDotCompleted: {
    backgroundColor: '#9E9E9E',
  },
  statusText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#737373',
  },
  statusTextActive: {
    color: '#2E7D32',
  },
  statusTextBreak: {
    color: '#F57C00',
  },
  statusTextCompleted: {
    color: '#737373',
  },
  
  shiftInfo: {
    marginBottom: 24,
  },
  shiftTime: {
    fontSize: 34,
    fontWeight: '800',
    color: '#171717',
    letterSpacing: -1,
    marginBottom: 10,
  },
  shiftDetailsList: {
    gap: 8,
  },
  shiftDetailItem: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  shiftDetailTextMain: {
    fontSize: 15,
    color: '#171717',
    fontWeight: '600',
    marginLeft: 10,
  },
  shiftDetailTextSub: {
    fontSize: 14,
    color: '#737373',
    fontWeight: '500',
    marginLeft: 10,
  },
  
  contextPanel: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#FFF0ED',
    paddingHorizontal: 16,
    paddingVertical: 14,
    borderRadius: 16,
    marginBottom: 24,
  },
  contextIconWrap: {
    width: 36,
    height: 36,
    borderRadius: 18,
    backgroundColor: '#FFFFFF',
    borderWidth: 1,
    borderColor: '#FBE9E7',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
  },
  contextTextWrap: {
    flex: 1,
  },
  contextTitle: {
    fontSize: 15,
    color: '#171717',
    fontWeight: '600',
    marginBottom: 2,
  },
  contextHighlight: {
    color: '#E6392F',
    fontWeight: '800',
  },
  contextSubtitle: {
    fontSize: 13,
    color: '#737373',
    fontWeight: '500',
  },
  contextArrowWrap: {
    width: 24,
    height: 24,
    borderRadius: 12,
    backgroundColor: '#FBE9E7',
    alignItems: 'center',
    justifyContent: 'center',
  },

  actionRow: {
    marginBottom: 24,
  },
  primaryBtnWrapperFull: {
    width: '100%',
    shadowColor: '#E6392F',
    shadowOffset: { width: 0, height: 8 },
    shadowOpacity: 0.3,
    shadowRadius: 16,
    elevation: 8,
  },
  gradientBtnFullWrap: {
    borderRadius: 20,
    overflow: 'hidden',
  },
  gradientBtnFull: {
    flexDirection: 'row',
    paddingVertical: 18,
    alignItems: 'center',
    justifyContent: 'center',
  },
  clockIconCircle: {
    width: 28,
    height: 28,
    borderRadius: 14,
    backgroundColor: 'rgba(255,255,255,0.25)',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 8,
  },
  primaryBtnTextFull: {
    color: '#FFFFFF',
    fontSize: 18,
    fontWeight: '700',
    letterSpacing: 0.5,
  },
  splitActions: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    gap: 12,
  },
  secondaryBtn: {
    flex: 1,
    flexDirection: 'row',
    backgroundColor: '#F5F5F5',
    paddingVertical: 16,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  primaryBtn: {
    flex: 1,
    shadowColor: '#E6392F',
    shadowOffset: { width: 0, height: 8 },
    shadowOpacity: 0.3,
    shadowRadius: 12,
    elevation: 6,
  },
  gradientBtnWrapper: {
    borderRadius: 16,
    overflow: 'hidden',
  },
  gradientBtn: {
    flexDirection: 'row',
    paddingVertical: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  primaryBtnText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '700',
    letterSpacing: 0.5,
  },
  secondaryBtnText: {
    color: '#171717',
    fontSize: 16,
    fontWeight: '700',
  },
  btnPressed: {
    opacity: 0.9,
  },

  shiftSummaryRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 24,
    gap: 8,
  },
  summaryPill: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 10,
    borderRadius: 12,
  },
  summaryText: {
    fontSize: 12,
    fontWeight: '600',
  },

  timeline: {
    marginTop: 4,
  },
  timelineLabelsTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 12,
  },
  timelineTime: {
    fontSize: 12,
    fontWeight: '800',
    color: '#171717',
  },
  timelineTrackContainer: {
    height: 8,
    justifyContent: 'center',
    marginBottom: 16,
  },
  timelineTrackBg: {
    position: 'absolute',
    left: 0,
    right: 0,
    height: 6,
    backgroundColor: '#F0F0F0',
    borderRadius: 3,
  },
  timelineTrackFill: {
    position: 'absolute',
    left: 0,
    height: 6,
    borderRadius: 3,
    overflow: 'hidden',
  },
  timelineNodeWrapper: {
    position: 'absolute',
    width: 24,
    height: 24,
    marginLeft: -12,
    alignItems: 'center',
    justifyContent: 'center',
    zIndex: 2,
  },
  timelineNodeGlow: {
    position: 'absolute',
    width: 24,
    height: 24,
    borderRadius: 12,
  },
  timelineNode: {
    width: 14,
    height: 14,
    borderRadius: 7,
    backgroundColor: '#FFFFFF',
    borderWidth: 3,
  },
  timelineLabelsBottom: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    position: 'relative',
    height: 40,
  },
  timelineLabelCol: {
    alignItems: 'center',
  },
  timelineLabel: {
    fontSize: 11,
    color: '#737373',
    fontWeight: '600',
  },

  section: {
    marginBottom: 24,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'baseline',
    marginBottom: 12,
    paddingHorizontal: 4,
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '700',
    color: '#737373',
    letterSpacing: 0.5,
  },
  linkText: {
    fontSize: 13,
    fontWeight: '600',
    color: '#E6392F',
  },



  upcomingCard: {
    flexDirection: 'row',
    backgroundColor: '#FFFFFF',
    borderRadius: 20,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.03,
    shadowRadius: 8,
    elevation: 2,
    overflow: 'hidden',
  },
  cardPressed: {
    transform: [{ scale: 0.98 }],
    opacity: 0.95,
  },
  accentLine: {
    width: 6,
  },
  upcomingContent: {
    flex: 1,
    padding: 16,
    paddingRight: 8,
  },
  upcomingHeaderRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 6,
  },
  upcomingDate: {
    fontSize: 15,
    fontWeight: '700',
    color: '#171717',
    marginRight: 8,
  },
  confirmedBadge: {
    backgroundColor: '#E8F5E9',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 6,
  },
  confirmedText: {
    fontSize: 10,
    fontWeight: '700',
    color: '#2E7D32',
  },
  conflictBadge: {
    backgroundColor: '#FFF0ED',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 6,
  },
  conflictText: {
    fontSize: 10,
    fontWeight: '700',
    color: '#E6392F',
  },
  upcomingRole: {
    fontSize: 14,
    fontWeight: '500',
    color: '#424242',
  },
  chevron: {
    alignSelf: 'center',
    marginRight: 16,
  },
  timeAmPm: {
    fontSize: 10,
    color: '#A3A3A3',
    fontWeight: '600',
    textTransform: 'uppercase',
  },
  shiftTimeAmPm: {
    fontSize: 18,
    color: '#FF8A65',
    fontWeight: '700',
    textTransform: 'uppercase',
  },
  timelineAmPm: {
    fontSize: 9,
    color: '#A3A3A3',
    fontWeight: '600',
    textTransform: 'uppercase',
  },
  upcomingAmPm: {
    fontSize: 10,
    color: '#A3A3A3',
    fontWeight: '600',
    textTransform: 'uppercase',
  },
});
